<?php

return [
    'openpub-press-mailing-list' => [
        'object_types' => ['openpub-press-item'],
        'args'         => [
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'labels' => [
                'name'              => __('Mailing list', 'openpub-persberichten'),
                'singular_name'     => __('Mailing list', 'openpub-persberichten'),
                'search_items'      => __('Search mailing lists', 'openpub-persberichten'),
                'all_items'         => __('All mailing lists', 'openpub-persberichten'),
                'parent_item'       => __('Parent mailing list', 'openpub-persberichten'),
                'parent_item_colon' => __('Parent mailing list:', 'openpub-persberichten'),
                'edit_item'         => __('Edit mailing list', 'openpub-persberichten'),
                'update_item'       => __('Update mailing list', 'openpub-persberichten'),
                'add_new_item'      => __('Add new mailing list', 'openpub-persberichten'),
                'new_item_name'     => __('New mailing list', 'openpub-persberichten'),
                'menu_name'         => __('Mailing lists', 'openpub-persberichten'),
            ]
        ],
        'names'        => [
            # Override the base names used for labels:
            'singular' => __('Mailing list', 'openpub-persberichten'),
            'plural'   => __('Mailing lists', 'openpub-persberichten'),
            'slug'     => 'openpub-press-mailing-list'
        ]
    ],
];
