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
                    'name' => __('Additional message', 'openpub-persberichten'),
                    'desc' => __('An additional message that will be added to each press release.', 'openpub-persberichten'),
                    'id'   => 'setting_additional_message',
                    'type' => 'textarea',
                ]
            ],
        ],
    ]
];
