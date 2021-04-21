<?php

namespace OWC\Persberichten\RestAPI\ItemFields;

use OWC\Persberichten\Support\CreatesFields;
use OWC\Persberichten\Models\Persbericht as PersberichtModel;
use OWC\Persberichten\Repositories\Persbericht;
use OWC\Persberichten\Foundation\Plugin;
use WP_Post;
use WP_Query;

class ConnectedField extends CreatesFields
{
    /**
     * Instance of the Plugin.
     *
     * @var Plugin
     */
    protected $plugin;

    /**
     * @param Plugin $plugin
     */
    public function __construct(Plugin $plugin)
    {
        $this->plugin      = $plugin;
        $this->respository = new Persbericht($plugin);
    }

    /**
     * Creates an array of connected posts.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function create(WP_Post $post): array
    {
        $persbericht    = PersberichtModel::makeFrom($post);
        $mailingListIDs = $this->getMailingListIDs($persbericht);

        return $this->getConnectedItems($mailingListIDs, $persbericht->getID());
    }

    /**
     * @param PersberichtModel $persbericht
     * 
     * @return array
     */
    protected function getMailingListIDs(PersberichtModel $persbericht): array
    {
        $terms = $persbericht->getTerms('openpub_press_mailing_list');

        if (!is_array($terms)) {
            return [];
        }

        return array_map(function ($term) {
            return $term->term_id;
        }, $terms);
    }

    /**
     * Get connected items and exclude current post.
     *
     * @param array $mailingListIDs
     * @param integer $persberichtID
     * 
     * @return array
     */
    protected function getConnectedItems(array $mailingListIDs, int $persberichtID): array
    {
        $items = $this->query($mailingListIDs, $persberichtID);

        if (empty($items)) {
            return [];
        }

        return array_map(function (WP_Post $post) {
            $persbericht = PersberichtModel::makeFrom($post);

            return [
                'id'                => $persbericht->getID(),
                'date'              => $persbericht->getDateI18n('Y-m-d H:i:s'),
                'portal_url'        => $this->respository->makePortalURL($persbericht->getPostName()),
                'title'             => $persbericht->getTitle(),
                'image'             => $persbericht->getThumbnail(),
                'content'           => $persbericht->getContent(),
                'additional_info'   => $this->respository->getAdditionalMessage(),
                'excerpt'           => $persbericht->getExcerpt(),
                'slug'              => $persbericht->getPostName(),
                'type'              => $persbericht->getPostType()
            ];
        }, $items);
    }

    /**
     * Get connected items based on taxonomy.
     *
     * @param array $mailingListIDs
     * @param integer $persberichtID
     * 
     * @return array
     */
    protected function query(array $mailingListIDs, int $persberichtID): array
    {
        $args = [
            'post_type' => 'openpub-press-item',
            'tax_query' => [
                [
                    'taxonomy' => 'openpub_press_mailing_list',
                    'field'    => 'term_id',
                    'terms'    => $mailingListIDs,
                ]
            ],
            'post__not_in' => [$persberichtID]
        ];

        $query = new WP_Query($args);

        return $query->posts;
    }
}
