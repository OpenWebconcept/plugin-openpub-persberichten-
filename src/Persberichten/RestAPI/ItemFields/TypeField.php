<?php

/**
 * Adds portal url field to the output.
 */

namespace OWC\OpenPub\Persberichten\RestAPI\ItemFields;

use OWC\OpenPub\Persberichten\Models\Persbericht;
use OWC\OpenPub\Persberichten\Support\CreatesFields;
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
        $terms     = $itemModel->getTerms('openpub_press_mailing_list');

        if (!is_array($terms)) {
            return [];
        }

        return $terms;
    }
}
