<?php

use OWC\OpenPub\Base\Repositories\Item;

return [
    /**
     * Examples of registering post types: https://johnbillion.com/extended-cpts/
     */
    'openpub-press-item' => [
        'args' => [
            // Add the post type to the site's main RSS feed:
            'show_in_feed' => false,
            // Show all posts on the post type archive:
            'archive' => [
                'nopaging' => true,
            ],
            'public'       => true,
            'show_ui'      => true,
            'supports'     => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'comments'],
            'menu_icon'    => 'dashicons-camera',
            'menu_position' => 5,
            'show_in_rest' => true,
            'admin_cols'   => [
                'type' => [
                    'title'    => _x('Type', 'Admin Filter definition', 'openpub-persberichten'),
                    'taxonomy' => 'openpub-press-type',
                ],
                'expired' => [
                    'title'    => __('Expired', 'openpub-persberichten'),
                    'function' => function () {
                        global $post;

                        $item = (new Item)
                            ->query(apply_filters('owc/openpub/rest-api/items/query/single', array_merge([], (new Item)->addExpirationParameters())))
                            ->find($post->ID);
                        if (!$item) {
                            echo sprintf('<span style="color: red">%s</span>', __('Expired', 'openpub-persberichten'));
                        } else {
                            $willExpire = get_post_meta($item['id'], '_owc_openpub_expirationdate', true);
                            if (!$willExpire) {
                                echo sprintf('<span>%s</span>', __('No expire date', 'openpub-persberichten'));
                            } else {
                                echo sprintf('<span style="color: green">%s %s</span>', __('Will expire on', 'openpub-persberichten'), date_i18n(get_option('date_format') . ', ' . get_option('time_format'), strtotime($willExpire)));
                            }
                        }
                    },
                ],
                'published' => [
                    'title'       => __('Published', 'openpub-persberichten'),
                    'post_field'  => 'post_date',
                    'date_format' => get_option('date_format') . ', ' . get_option('time_format'),
                ],
                'orderby' => [],
            ],
            // Add a dropdown filter to the admin screen:
            'admin_filters' => [
                'type' => [
                    'title'    => _x('Type', 'Admin Filter definition', 'openpub-persberichten'),
                    'taxonomy' => 'openpub-press-type',
                ],
            ],
            'labels' => [
                'singular_name'      => __('Persbericht', 'openpub-persberichten'),
                'menu_name'          => __('Persberichten', 'openpub-persberichten'),
                'name_admin_bar'     => __('Nieuw persbericht', 'openpub-persberichten'),
                'add_new'            => __('Voeg nieuw persbericht toe', 'openpub-persberichten'),
                'add_new_item'       => __('Voeg persbericht toe', 'openpub-persberichten'),
                'new_item'           => __('Nieuw persbericht', 'openpub-persberichten'),
                'edit_item'          => __('Wijzig persbericht', 'openpub-persberichten'),
                'view_item'          => __('Bekijk persbericht', 'openpub-persberichten'),
                'all_items'          => __('Alle persberichten', 'openpub-persberichten'),
                'search_items'       => __('Zoek persbericht', 'openpub-persberichten'),
                'parent_item_colon'  => __('Hoofd persberichten:', 'openpub-persberichten'),
                'not_found'          => __('Geen persberichten gevonden.', 'openpub-persberichten'),
                'not_found_in_trash' => __('Geen persberichten gevonden in de prullenbak.', 'openpub-persberichten'),
            ],
        ],
        // Override the base names used for labels:
        'names' => [
            'slug'     => 'openpub-press-item',
            'singular' => _x('Persbericht', 'Posttype definition', 'openpub-persberichten'),
            'plural'   => _x('Persberichten', 'Posttype definition', 'openpub-persberichten'),
            'name'     => _x('Persberichten', 'post type general name', 'openpub-persberichten'),
        ],
    ],
];
