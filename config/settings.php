<?php

return [
    'persberichten'  => [
        'id'             => 'persberichten',
        'title'          => _x('Persberichten', 'OpenPub instellingen subpagina', 'openpub-persberichten'),
        'settings_pages' => '_owc_openpub_press_settings',
        'tab'            => 'persberichten',
        'fields'         => [
            'settings' => [
                'settings_additional_message'  => [
                    'name' => __('Aanvullend bericht', 'openpub-persberichten'),
                    'desc' => __('Een aanvullend bericht dat aan ieder persbericht wordt toegevoegd.', 'openpub-persberichten'),
                    'id'   => 'setting_additional_message',
                    'type' => 'textarea',
                ]
            ],
        ],
    ]
];
