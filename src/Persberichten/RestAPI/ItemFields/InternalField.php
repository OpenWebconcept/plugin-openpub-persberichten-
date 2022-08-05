<?php

namespace OWC\Persberichten\RestAPI\ItemFields;

use OWC\Persberichten\Models\Persbericht;
use OWC\Persberichten\Support\CreatesFields;
use WP_Post;

class InternalField extends CreatesFields
{
    /**
     * The condition for the creator.
     *
     * @return callable
     */
    protected function condition(): callable
    {
        return function () {
            return \is_user_logged_in();
        };
    }

    /**
     * Create the internal info field for a given post.
     */
    public function create(WP_Post $post): string
    {
        $itemModel = Persbericht::makeFrom($post);
        $internal  = $itemModel->getMeta('press_mailing_internal_info', '', true, '_owc_');

        if (empty($internal)) {
            return '';
        }

        return $internal;
    }
}
