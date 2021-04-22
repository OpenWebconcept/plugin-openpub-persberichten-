<?php

namespace OWC\Persberichten\Laposta;

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

    public function __construct(Plugin $plugin)
    {
        $this->plugin   = $plugin;
        $this->request  = new LapostaRequest();
    }

    public function handleSave(WP_Post $post, \WP_REST_Request $request, bool $creating): void
    {
        if (wp_is_post_revision($post->ID) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) {
            return;
        }

        if (in_array($post->post_status, ['draft', 'pending', 'auto-draft'])) {
            return;
        }

        $alreadyCreated = get_post_meta($post->ID, '_owc_press_release_is_created', true);

        if ($post->post_type !== 'openpub-press-item' || $alreadyCreated === '1') {
            return;
        }

        $pressRelease = Persbericht::makeFrom($post);
        $mailingLists = $pressRelease->getTerms('openpub_press_mailing_list');

        if (!is_array($mailingLists) || empty($mailingLists)) {
            $this->returnJsonError('412', 'No mailing list terms connected.');
        }

        $this->handleLaposta($pressRelease, $mailingLists);
    }

    /**
     * Fires after the first publication of a press release.
     * Send post content to a laposta campaign.
     *
     * @param Persbericht $pressRelease
     * 
     * @return void
     */
    protected function handleLaposta(Persbericht $pressRelease, array $mailingLists): void
    {
        $mailinglistIDs = $this->getTermsMeta($mailingLists, 'openpub_press_mailing_list_id');

        foreach ($mailinglistIDs as $mailingListID) {
            if (!$this->campaignExists($mailingListID)) {
                continue;
            }

            $this->populateCampaign($pressRelease, $mailingListID);
        }
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
     * @param string $mailingListID
     * 
     * @return boolean
     */
    protected function campaignExists(string $mailingListID): bool
    {
        $endpoint = sprintf('/v2/campaign/%s', $mailingListID);
        $result   = $this->request->request($endpoint);

        if (isset($result['error']) || empty($result['campaign'])) {
            return false;
        }

        return true;
    }

    /**
     * Populate Laposta campaign.
     *
     * @param Persbericht $pressRelease
     * @param string $mailingListID
     * 
     * @return void
     */
    protected function populateCampaign(Persbericht $pressRelease, string $mailingListID): void
    {
        $requestBody = $this->makeRequestBody($pressRelease, $mailingListID);

        if (empty($requestBody)) {
            $this->returnJsonError('412', 'Something went wrong with creating the request body.');
        }

        $endpoint = sprintf('/v2/campaign/%s/content', $mailingListID);
        $result   = $this->request->request($endpoint, 'POST', $requestBody);

        if (isset($result['error']) || empty($result['campaign'])) {
            $this->returnJsonError('501', 'Something went wrong with filling the content of the campaign.');
        }

        $this->sendCampaign($pressRelease, $mailingListID);
    }

    /**
     * Send the campaign to the subscribers.
     *
     * @param Persbericht $pressRelease
     * @param string $mailingListID
     * 
     * @return void
     */
    protected function sendCampaign(Persbericht $pressRelease, string $mailingListID): void
    {
        $endpoint = sprintf('/v2/campaign/%s/action/send', $mailingListID);
        $result   = $this->request->request($endpoint, 'POST');

        if (isset($result['error']) || empty($result['campaign'])) {
            $this->returnJsonError('501', 'Something went wrong with sending the campaign to the subscribers.');
            return;
        }

        /**
         * Parameter $creating is not reliable because of revisions.
         * Update the meta so we know the post is created, for future references.
         */
        update_post_meta($pressRelease->getID(), '_owc_press_release_is_created', '1');
    }

    /**
     * Laposta uses the importURL to retrieve the html of an external source.
     *
     * @param Persbericht $pressRelease
     * @param string $mailingListID
     * 
     * @return array
     */
    protected function makeRequestBody(Persbericht $pressRelease, string $mailingListID): array
    {
        $importURL = $this->makeImportURL($pressRelease->getPostName());

        if (empty($importURL)) {
            return [];
        }

        return [
            'campaign_id'   => $mailingListID,
            'import_url'    => $importURL
        ];
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
     * @param string $code
     * @param string $message
     * 
     * @return void
     */
    protected function returnJsonError(string $code, string $message): void
    {
        $error = new \WP_Error($code, $message, ['status' => (int)$code]);
        wp_send_json_error($error, (int) $code);
    }
}
