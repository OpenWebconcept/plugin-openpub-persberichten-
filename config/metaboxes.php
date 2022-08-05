<?php

return [
    'internal' => [
        'id'         => 'openpub_metadata',
        'title'      => __('Internal', 'persberichten'),
        'post_types' => ['press-item'],
        'context'    => 'normal',
        'priority'   => 'high',
        'autosave'   => true,
        'fields'     => [
            'internal'   => [
                'internal_info' => [
                    'name' => __('Internal info', 'persberichten'),
                    'desc' => __('Internal info is only included in the newsletter. Please make sure to select the correct internal mailing list.', 'persberichten'),
                    'id'   => 'press_mailing_internal_info',
                    'type' => 'textarea',
                ]
            ],
        ]
    ]
];
