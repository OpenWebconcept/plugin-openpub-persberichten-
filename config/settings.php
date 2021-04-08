<?php

return [
    'pressreleases'  => [
        'id'             => 'pressreleases',
        'title'          => __('Press releases', 'openpub-persberichten'),
        'settings_pages' => '_owc_openpub_press_settings',
        'tab'            => 'pressreleases',
        'fields'         => [
            'settings' => [
                'settings_additional_message'  => [
                    'name' => __('Additional info', 'openpub-persberichten'),
                    'desc' => __('Additional info that will be added to each press release.', 'openpub-persberichten'),
                    'id'   => 'setting_additional_message',
                    'type' => 'wysiwyg',
                ]
            ],
        ],
    ]
];
