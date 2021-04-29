<?php

return [
    'pressreleases' => [
        'id'            => '_owc_press_settings',
        'option_name'   => '_owc_press_settings',
        'menu_title'    => __('Press releases', 'persberichten'),
        'icon_url'      => 'dashicons-admin-settings',
        'position'      => 9,
        'parent'        => '_owc_openpub_base_settings',
        'submenu_title' => __('Press releases', 'persberichten'),
        'columns'       => 1,
        'submit_button' => __('Save', 'persberichten'),
        'tabs'          => [
            'pressreleases' => __('Press releases', 'persberichten'),
        ],
    ],
];
