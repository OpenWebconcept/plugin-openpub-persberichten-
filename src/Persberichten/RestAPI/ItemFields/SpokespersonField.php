<?php

namespace OWC\Persberichten\RestAPI\ItemFields;

use OWC\Persberichten\Models\Persbericht;
use OWC\Persberichten\Support\CreatesFields;
use WP_Post;

class SpokespersonField extends CreatesFields
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
     * Create the type array field for a given post.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function create(WP_Post $post): array
    {
        $itemModel = Persbericht::makeFrom($post);
		$spokesperson = [
        	'name' => $itemModel->getMeta('press_mailing_spokesperson_name', '', true, '_owc_'),
			'url' => $itemModel->getMeta('press_mailing_spokesperson_name', '', true, '_owc_'),
		];
		$spokesperson = array_filter($spokesperson);

        return $spokesperson;
    }
}
