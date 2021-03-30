<?php

return [
    'openpub-press-type' => [
        'object_types' => ['openpub-press-item'],
        'args'         => [
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'capabilities'      => [
                //                'manage_terms' => 'manage_openpub_categories',
                //                'edit_terms'   => 'manage_openpub_categories',
                //                'delete_terms' => 'manage_openpub_categories',
                //                'assign_terms' => 'edit_openpub_posts'
            ]
        ],
        'names'        => [
            # Override the base names used for labels:
            'singular' => _x('Type', 'Taxonomy definition', 'openpub-persberichten'),
            'plural'   => _x('Types', 'Taxonomy definition', 'openpub-persberichten'),
            'slug'     => 'openpub-press-type'
        ]
    ],
];
