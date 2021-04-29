<?php

namespace OWC\Persberichten\Repositories;

use WP_Post;
use OWC\Persberichten\Models\Persbericht as PersberichtModel;

class Persbericht extends AbstractRepository
{
    protected $posttype = 'press-item';

    protected static $globalFields = [];

    /**
     * Transform a single WP_Post item.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function transform(WP_Post $post): array
    {
        $persbericht = PersberichtModel::makeFrom($post);

        $data = [
            'id'                => $persbericht->getID(),
            'date'              => $persbericht->getDateI18n('Y-m-d H:i:s'),
            'portal_url'        => $this->makePortalURL($persbericht->getPostName()),
            'title'             => $persbericht->getTitle(),
            'image'             => $persbericht->getThumbnail(),
            'content'           => $persbericht->getContent(),
            'additional_info'   => $this->getAdditionalMessage(),
            'excerpt'           => $persbericht->getExcerpt(65),
            'slug'              => $persbericht->getPostName(),
            'type'              => $persbericht->getPostType()
        ];

        $data = $this->assignFields($data, $post);

        return $data;
    }

    /**
     * Make the portal url used in the portal.
     *
     * @param string $slug
     * 
     * @return string
     */
    public function makePortalURL(string $slug): string
    {
        if (empty($this->plugin->settings->getPortalURL()) || empty($this->plugin->settings->getPortalItemSlug())) {
            return '';
        }

        return sprintf('%s/%s/%s', $this->plugin->settings->getPortalURL(), $this->plugin->settings->getPortalItemSlug(), $slug);
    }

    /**
     * Add additional message to post content.
     *
     * @return string
     */
    public function getAdditionalMessage(): string
    {
        if (empty($this->plugin->settings->getAdditionalMessage())) {
            return '';
        }

        return $this->plugin->settings->getAdditionalMessage();
    }

    /**
     * Add tax query to current query.
     *
     * @param string $type
     * 
     * @return array
     */
    public static function addFilterTypeParameters(string $type = ''): array
    {
        if (empty($type)) {
            return [];
        }

        return [
            'tax_query' => [
                [
                    'taxonomy' => 'press_mailing_list',
                    'terms'    => $type,
                    'field'    => 'slug'
                ]
            ]
        ];
    }
}
