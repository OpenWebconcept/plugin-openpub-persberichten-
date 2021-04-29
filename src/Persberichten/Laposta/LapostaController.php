<?php

namespace OWC\Persberichten\Laposta;

use OWC\Persberichten\Exceptions\LapostaRequestException;
use OWC\Persberichten\Models\Persbericht;
use OWC\Persberichten\Foundation\Plugin;
use \WP_Post;

class LapostaController
{
    /**
     * Instance of the plugin.
     *
     * @var Plugin
     */
    protected $plugin;

    /**
     * Instance of the plugin.
     *
     * @var LapostaRequest
     */
    protected $request;

    public function __construct(Plugin $plugin, LapostaRequest $request)
    {
        $this->plugin   = $plugin;
        $this->request  = $request;
    }

    public function handleSave(WP_Post $post, \WP_REST_Request $request, bool $creating): void
    {
        if (wp_is_post_revision($post->ID) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) {
            return;
        }

        if (!in_array($post->post_status, ['publish'])) {
            return;
        }

        $alreadyCreated = get_post_meta($post->ID, '_owc_press_release_is_created', true);

        if ($post->post_type !== 'press-item' || $alreadyCreated === '1') {
            return;
        }

        $pressRelease = Persbericht::makeFrom($post);
        $mailingLists = $pressRelease->getTerms('press_mailing_list');

        if (!is_array($mailingLists) || is_wp_error($mailingLists)) {
            $mailingLists = [];
        }

        $this->handleLaposta($pressRelease, $mailingLists);
    }

    /**
     * Fires after the first publication of a press release.
     * Send post content to a Laposta campaign.
     *
     * @param Persbericht $pressRelease
     * 
     * @return void
     */
    protected function handleLaposta(Persbericht $pressRelease, array $mailingLists): void
    {
        $mailinglistIDs = $this->getTermsMeta($mailingLists, 'press_mailing_list_id');
        $campaignID     = $this->createCampaign($pressRelease, $mailinglistIDs);

        try {
            $this->campaignExists($campaignID);
        } catch (LapostaRequestException $e) {
            $this->returnJsonError($e);
        }

        $this->populateCampaign($pressRelease, $campaignID);
    }

    /**
     * Get meta values of terms.
     *
     * @param array $terms
     * @param string $metaKey
     * 
     * @return array
     */
    protected function getTermsMeta(array $terms, string $metaKey): array
    {
        $metaValues = [];

        foreach ($terms as $term) {
            $metaValue = get_term_meta($term->term_id, $metaKey, true);

            if (!$metaValue) {
                continue;
            }

            $metaValues[] = $metaValue;
        }

        return $metaValues;
    }

    /**
     * Validate if the laposta campaign exists.
     *
     * @param string $campaignID
     * 
     * @throws LapostaRequestException
     * @return boolean
     */
    protected function campaignExists(string $campaignID = ''): bool
    {
        if (empty($campaignID)) {
            throw new LapostaRequestException('Campaign ID is empty');
        }

        $endpoint = sprintf('/v2/campaign/%s', $campaignID);

        try {
            $this->request->request($endpoint);
        } catch (LapostaRequestException $e) {
            throw new LapostaRequestException($e->getMessage());
        }

        return true;
    }

    /**
     * @param Persbericht $pressRelease
     * @param array $mailingListIDs
     * 
     * @return string
     */
    protected function createCampaign(Persbericht $pressRelease, array $mailingListIDs): string
    {
        $requestBody = $this->makeCampaignBody($pressRelease, $mailingListIDs);
        $endpoint    = '/v2/campaign';

        try {
            $result = $this->request->request($endpoint, 'POST', $requestBody);
        } catch (LapostaRequestException $e) {
            $this->returnJsonError($e);
        }

        return $result['campaign']['campaign_id'] ?? '';
    }

    /**
     * Populate Laposta campaign.
     *
     * @param Persbericht $pressRelease
     * @param string $campaignID
     * 
     * @return void
     */
    protected function populateCampaign(Persbericht $pressRelease, string $campaignID): void
    {
        $campaignBody = $this->makeCampaignContentBody($pressRelease, $campaignID);
        $endpoint     = sprintf('/v2/campaign/%s/content', $campaignID);

        try {
            $this->request->request($endpoint, 'POST', $campaignBody);
        } catch (LapostaRequestException $e) {
            $this->returnJsonError($e);
        }

        $this->sendCampaign($pressRelease, $campaignID);
    }

    /**
     * Send the campaign to the subscribers.
     *
     * @param Persbericht $pressRelease
     * @param string $campaignID
     * 
     * @return void
     */
    protected function sendCampaign(Persbericht $pressRelease, string $campaignID): void
    {
        $endpoint = sprintf('/v2/campaign/%s/action/send', $campaignID);

        try {
            $this->request->request($endpoint, 'POST');
        } catch (LapostaRequestException $e) {
            $this->returnJsonError($e);
        }

        /**
         * Parameter $creating is not reliable because of revisions.
         * Update the meta so we know the post is created, for future references.
         */
        update_post_meta($pressRelease->getID(), '_owc_press_release_is_created', '1');
    }

    /**
     * Body used for creating a campaign.
     *
     * @param Persbericht $pressRelease
     * @param array $mailingListIDs
     * 
     * @return array
     */
    protected function makeCampaignBody(Persbericht $pressRelease, array $mailingListIDs): array
    {
        return [
            'type'    => 'regular',
            'name'    => $pressRelease->getTitle(),
            'subject' => $pressRelease->getTitle(),
            'from' => [
                'name' => $this->getOrganisationName(),
                'email' => $this->getOrganisationEmail()
            ],
            'list_ids' => $mailingListIDs,
        ];
    }

    /**
     * Fill the campaign after it has been created.
     *
     * @param Persbericht $pressRelease
     * @param string $campaignID
     * 
     * @return array
     */
    protected function makeCampaignContentBody(Persbericht $pressRelease, string $campaignID): array
    {
        $importURL = $this->makeImportURL($pressRelease->getPostName());

        if (empty($importURL)) {
            return [];
        }

        return [
            'campaign_id'   => $campaignID,
            'import_url'    => $importURL,
            'inline_css'    => true
        ];
    }

    protected function getOrganisationName(): string
    {
        return $this->plugin->settings->getOrganisationName();
    }

    protected function getOrganisationEmail(): string
    {
        return $this->plugin->settings->getOrganisationEmail();
    }

    /**
     * Make the required import url for Laposta.
     *
     * @param string $slug
     * 
     * @return string
     */
    protected function makeImportURL(string $slug): string
    {
        if (empty($this->plugin->settings->getPortalURL()) || empty($this->plugin->settings->getPortalItemSlug())) {
            return '';
        }

        return sprintf('%s/%s/%s/laposta', $this->plugin->settings->getPortalURL(), $this->plugin->settings->getPortalItemSlug(), $slug);
    }

    /**
     * @param \Exception $exception
     * 
     * @return void
     */
    protected function returnJsonError(\Exception $exception): void
    {
        $error = new \WP_Error($exception->getCode(), $exception->getMessage(), ['status' => $exception->getCode()]);
        wp_send_json_error($error, $exception->getCode());
    }
}
