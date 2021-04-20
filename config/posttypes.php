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
                    'title'    => __('Mailing list', 'openpub-persberichten'),
                    'taxonomy' => 'openpub_press_mailing_list',
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
                    'title'    => __('Mailing list', 'openpub-persberichten'),
                    'taxonomy' => 'openpub_press_mailing_list',
                ],
            ],
            'labels' => [
                'singular_name'      => __('Press release', 'openpub-persberichten'),
                'menu_name'          => __('Press releases', 'openpub-persberichten'),
                'name_admin_bar'     => __('New press release', 'openpub-persberichten'),
                'add_new'            => __('Add new press release', 'openpub-persberichten'),
                'add_new_item'       => __('Add press release', 'openpub-persberichten'),
                'new_item'           => __('New press release', 'openpub-persberichten'),
                'edit_item'          => __('Edit press release', 'openpub-persberichten'),
                'view_item'          => __('View press release', 'openpub-persberichten'),
                'all_items'          => __('All press releases', 'openpub-persberichten'),
                'search_items'       => __('Search press release', 'openpub-persberichten'),
                'parent_item_colon'  => __('Parent press release:', 'openpub-persberichten'),
                'not_found'          => __('No press releases found.', 'openpub-persberichten'),
                'not_found_in_trash' => __('No press releases found in trash.', 'openpub-persberichten'),
            ],
        ],
        // Override the base names used for labels:
        'names' => [
            'slug'     => 'persberichten',
            'singular' => __('Press release', 'openpub-persberichten'),
            'plural'   => __('Press releases', 'openpub-persberichten'),
            'name'     => __('Press releases', 'openpub-persberichten'),
        ],
    ],
];
