<?php

return [
    'press_mailing_list' => [
        'object_types' => ['press-item'],
        'args'         => [
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'labels' => [
                'name'              => __('Mailing list', 'persberichten'),
                'singular_name'     => __('Mailing list', 'persberichten'),
                'search_items'      => __('Search mailing lists', 'persberichten'),
                'all_items'         => __('All mailing lists', 'persberichten'),
                'parent_item'       => __('Parent mailing list', 'persberichten'),
                'parent_item_colon' => __('Parent mailing list:', 'persberichten'),
                'edit_item'         => __('Edit mailing list', 'persberichten'),
                'update_item'       => __('Update mailing list', 'persberichten'),
                'add_new_item'      => __('Add new mailing list', 'persberichten'),
                'new_item_name'     => __('New mailing list', 'persberichten'),
                'menu_name'         => __('Mailing lists', 'persberichten'),
            ]
        ],
        'names'        => [
            # Override the base names used for labels:
            'singular' => __('Mailing list', 'persberichten'),
            'plural'   => __('Mailing lists', 'persberichten'),
            'slug'     => 'verzendlijst'
        ]
    ],
];
