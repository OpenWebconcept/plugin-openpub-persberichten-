<?php

namespace OWC\OpenPub\Persberichten\Repositories;

use WP_Post;
use OWC\OpenPub\Persberichten\Models\Persbericht as PressRelease;

class Persbericht extends AbstractRepository
{
    protected $posttype = 'openpub-press-item';

    protected static $globalFields = [];

    /**
     * Add additional query arguments.
     *
     * @param array $args
     *
     * @return $this
     */
    public function query(array $args)
    {
        $this->queryArgs = array_merge($this->queryArgs, $args);

        return $this;
    }

    /**
     * Transform a single WP_Post item.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function transform(WP_Post $post): array
    {
        $pressRelease = PressRelease::makeFrom($post);

        $data = [
            'id'                => $pressRelease->getID(),
            'date'              => $pressRelease->getDateI18n('Y-m-d H:i:s'),
            'portal_url'        => $this->makePortalURL($pressRelease->getPostName()),
            'title'             => $pressRelease->getTitle(),
            'image'             => $pressRelease->getThumbnail(),
            'content'           => $pressRelease->getContent(),
            'additional_info'   => $this->getAdditionalMessage(),
            'excerpt'           => $pressRelease->getExcerpt(),
            'slug'              => $pressRelease->getPostName(),
            'type'              => $pressRelease->getPostType()
        ];

        $data = $this->assignFields($data, $post);

        return $data;
    }

    protected function makePortalURL(string $slug): string
    {
        $link = '';

        if (!empty($this->plugin->settings->getPortalURL())) {
            $link .= trailingslashit($this->plugin->settings->getPortalURL());
        }

        if (!empty($this->plugin->settings->getPortalItemSlug())) {
            $link .= trailingslashit($this->plugin->settings->getPortalItemSlug());
        }

        $link .= $slug;

        return $link;
    }

    /**
     * Add additional message to post content.
     *
     * @return string
     */
    protected function getAdditionalMessage(): string
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
                    'taxonomy' => 'openpub-press-mailing-list',
                    'terms'    => $type,
                    'field'    => 'slug'
                ]
            ]
        ];
    }
}
