<?php

namespace OWC\Persberichten\RestAPI\ItemFields;

use OWC\Persberichten\Models\Persbericht;
use OWC\Persberichten\Support\CreatesFields;
use WP_Post;

class SubtitleField extends CreatesFields
{
    /**
     * The condition for the creator.
     *
     * @return callable
     */
    protected function condition(): callable
    {
        return function () {
            return true;
        };
    }

    /**
     * Create the internal info field for a given post.
     */
    public function create(WP_Post $post): string
    {
        $itemModel = Persbericht::makeFrom($post);
        $subtitle  = $itemModel->getMeta('press_mailing_subtitle', '', true, '_owc_');

        if (empty($subtitle)) {
            return '';
        }

        return $subtitle;
    }
}
