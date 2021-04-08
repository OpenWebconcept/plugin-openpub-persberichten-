<?php

namespace OWC\OpenPub\Persberichten\Repositories;

use WP_Post;

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
    public function transform(WP_Post $post)
    {
        $data = [
            'id'                => $post->ID,
            'title'             => $post->post_title,
            'content'           => apply_filters('the_content', $post->post_content),
            'additional_info'   => $this->addAdditionalMessage(),
            'excerpt'           => $post->post_excerpt,
            'date'              => $post->post_date,
            'slug'              => $post->post_name
        ];

        $data = $this->assignFields($data, $post);

        return $data;
    }

    /**
     * Add additional message to content.
     *
     * @return string
     */
    protected function addAdditionalMessage(): string
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
        return [
            'tax_query' => [
                [
                    'taxonomy' => 'openpub-press-mailing-list',
                    'terms'    => $type,
                    'field'    => 'slug'
                ]
            ],
        ];
    }
}
