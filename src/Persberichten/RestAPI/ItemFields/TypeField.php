<?php

namespace OWC\Persberichten\RestAPI\ItemFields;

use OWC\Persberichten\Support\CreatesFields;
use OWC\Persberichten\Models\Persbericht;
use WP_Post;

class TypeField extends CreatesFields
{
    /**
     * Create the type array field for a given post.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function create(WP_Post $post): array
    {
        $itemModel = Persbericht::makeFrom($post);
        $terms     = $itemModel->getTerms('press_mailing_list');

        if (!is_array($terms)) {
            return [];
        }

        return $terms;
    }
}
