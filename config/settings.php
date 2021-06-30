<?php

return [
    'pressreleases'  => [
        'id'             => 'pressreleases',
        'title'          => __('Press releases', 'persberichten'),
        'settings_pages' => '_owc_press_settings',
        'tab'            => 'pressreleases',
        'fields'         => [
            'settings' => [
                'settings_press_release_portal_url' => [
                    'name' => __('Portal URL', 'persberichten'),
                    'desc' => __('URL including http(s)://', 'persberichten'),
                    'id'   => 'setting_portal_url',
                    'type' => 'text',
                ],
                'settings_press_release_slug' => [
                    'name' => __('Portal press release item slug', 'persberichten'),
                    'desc' => __('URL for press release items in the portal, eg "persberichten"', 'persberichten'),
                    'id'   => 'setting_portal_press_release_item_slug',
                    'type' => 'text',
                ],
                'settings_additional_message'  => [
                    'name' => __('Additional message', 'persberichten'),
                    'desc' => __('Additional message that will be added to each press release.', 'persberichten'),
                    'id'   => 'setting_additional_message',
                    'type' => 'wysiwyg',
                ]
            ],
        ],
    ]
];
