<?php

return [
    'test' => [
        'id'            => '_owc_openpub_press_settings',
        'option_name'   => '_owc_openpub_press_settings',
        'menu_title'    => __('Persberichten', 'openpub-persberichten'),
        'parent'        => '_owc_openpub_base_settings',
        'submenu_title' => _x('Persberichten', 'OpenPub settings subpage', 'openpub-persberichten'),
        'columns'       => 1,
        'submit_button' => _x('Opslaan', 'OpenPub settings subpage', 'openpub-persberichten'),
        'tabs'          => [
            'persberichten' => _x('Persberichten', 'OpenPub settings tab', 'openpub-persberichten'),
        ],
    ],
];
