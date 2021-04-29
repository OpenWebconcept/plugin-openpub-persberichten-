<?php

return [
    /**
     * Examples of registering post types: https://johnbillion.com/extended-cpts/
     */
    'press-item' => [
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
                    'title'    => __('Mailing list', 'persberichten'),
                    'taxonomy' => 'press_mailing_list',
                ],
                'published' => [
                    'title'       => __('Published', 'persberichten'),
                    'post_field'  => 'post_date',
                    'date_format' => get_option('date_format') . ', ' . get_option('time_format'),
                ],
                'orderby' => [],
            ],
            // Add a dropdown filter to the admin screen:
            'admin_filters' => [
                'type' => [
                    'title'    => __('Mailing list', 'persberichten'),
                    'taxonomy' => 'press_mailing_list',
                ],
            ],
            'labels' => [
                'singular_name'      => __('Press release', 'persberichten'),
                'menu_name'          => __('Press releases', 'persberichten'),
                'name_admin_bar'     => __('New press release', 'persberichten'),
                'add_new'            => __('Add new press release', 'persberichten'),
                'add_new_item'       => __('Add press release', 'persberichten'),
                'new_item'           => __('New press release', 'persberichten'),
                'edit_item'          => __('Edit press release', 'persberichten'),
                'view_item'          => __('View press release', 'persberichten'),
                'all_items'          => __('All press releases', 'persberichten'),
                'search_items'       => __('Search press release', 'persberichten'),
                'parent_item_colon'  => __('Parent press release:', 'persberichten'),
                'not_found'          => __('No press releases found.', 'persberichten'),
                'not_found_in_trash' => __('No press releases found in trash.', 'persberichten'),
            ],
        ],
        // Override the base names used for labels:
        'names' => [
            'slug'     => 'persberichten',
            'singular' => __('Press release', 'persberichten'),
            'plural'   => __('Press releases', 'persberichten'),
            'name'     => __('Press releases', 'persberichten'),
        ],
    ],
];
