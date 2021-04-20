<?php

namespace OWC\OpenPub\Persberichten\Laposta;

use OWC\OpenPub\Persberichten\Models\Persbericht;
use \WP_Post;

class LapostaController
{
    public function __construct()
    {
        $this->request  = new LapostaRequest();
    }

    public function handleSave(int $postID, $post, bool $update): void
    {
        if (wp_is_post_revision($postID) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) {
            return;
        }

        if (in_array($post->post_status, ['draft', 'pending', 'auto-draft'])) {
            return;
        }

        $alreadyCreated = get_post_meta($postID, '_owc_press_release_is_created', true);

        if ($post->post_type !== 'openpub-press-item' || $alreadyCreated === '1') {
            return;
        }

        /**
         * Parameter $update is not reliable because of revisions.
         * Update the meta so we know the post is created, for future references.
         */
        update_post_meta($postID, '_owc_press_release_is_created', '1');

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

            $this->pushToCampaign($endpoint, $post, $mailingListID);
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
     * @param WP_Post $post
     * @param string $mailingListID
     * 
     * @return void
     */
    protected function pushToCampaign(string $endpoint, WP_Post $post, string $mailingListID): void
    {
        $requestBody = $this->makeRequestBody($post, $mailingListID);
        $result      = $this->request->request($endpoint, 'POST', $requestBody);

        if (isset($result['error']) || empty($result['campaign'])) {
            return;
        }

        var_dump($result);
        die;
    }

    protected function makeRequestBody(WP_Post $post, string $mailingListID): array
    {
        return [
            'campaign_id'   => $mailingListID,
            // 'html'          => $post->post_content,
            'import_url'    => 'https://www.google.nl' // dit wordt de single page van een persbericht.
        ];
    }
}
