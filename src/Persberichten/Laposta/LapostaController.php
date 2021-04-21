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

        /**
         * Parameter $creating is not reliable because of revisions.
         * Update the meta so we know the post is created, for future references.
         */
        update_post_meta($post->ID, '_owc_press_release_is_created', '1');

        $this->handleLaposta($post);
    }

    /**
     * Fires after the first publication of a press release.
     * Send post content to a laposta campaign.
     *
     * @param WP_Post $post
     * 
     * @return void
     */
    protected function handleLaposta(WP_Post $post): void
    {
        $pressRelease = Persbericht::makeFrom($post);
        $mailingLists = $pressRelease->getTerms('openpub_press_mailing_list');

        if (!is_array($mailingLists) || empty($mailingLists)) {
            return;
        }

        $mailinglistIDs = $this->getTermsMeta($mailingLists, 'openpub_press_mailing_list_id');

        foreach ($mailinglistIDs as $mailingListID) {
            $endpoint = sprintf('/v2/campaign/%s/content', $mailingListID);

            if (!$this->campaignExists($endpoint)) {
                continue;
            }

            $this->pushToCampaign($endpoint, $pressRelease, $mailingListID);
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
     * @param string $endpoint
     * 
     * @return boolean
     */
    protected function campaignExists(string $endpoint): bool
    {
        $result = $this->request->request($endpoint);

        if (isset($result['error']) || empty($result['campaign'])) {
            return false;
        }

        return true;
    }

    /**
     * Push to laposta campaign.
     *
     * @param string $endpoint
     * @param Persbericht $pressRelease
     * @param string $mailingListID
     * 
     * @return void
     */
    protected function pushToCampaign(string $endpoint, Persbericht $pressRelease, string $mailingListID): void
    {
        $requestBody = $this->makeRequestBody($pressRelease, $mailingListID);
        $result      = $this->request->request($endpoint, 'POST', $requestBody);

        if (isset($result['error']) || empty($result['campaign'])) {
            return;
        }
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
}
