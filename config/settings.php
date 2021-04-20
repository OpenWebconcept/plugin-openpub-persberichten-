<?php

return [
    'pressreleases'  => [
        'id'             => 'pressreleases',
        'title'          => __('Press releases', 'openpub-persberichten'),
        'settings_pages' => '_owc_openpub_press_settings',
        'tab'            => 'pressreleases',
        'fields'         => [
            'settings' => [
                'settings_press_release_slug' => [
                    'name' => __('Portal press release item slug', 'openpub-persberichten'),
                    'desc' => __('URL for press release items in the portal, eg "persberichten"', 'openpub-persberichten'),
                    'id'   => 'setting_portal_press_release_item_slug',
                    'type' => 'text',
                ],
                'settings_additional_message'  => [
                    'name' => __('Additional message', 'openpub-persberichten'),
                    'desc' => __('Additional message that will be added to each press release.', 'openpub-persberichten'),
                    'id'   => 'setting_additional_message',
                    'type' => 'wysiwyg',
                ]
            ],
        ],
    ]
];
