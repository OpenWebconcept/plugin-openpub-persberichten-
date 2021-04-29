<?php

return [

    // Service Providers.
    'providers'    => [
        // Global providers.
        OWC\Persberichten\Laposta\LapostaServiceProvider::class,
        OWC\Persberichten\RestAPI\RestAPIServiceProvider::class,
        OWC\Persberichten\PostType\PostTypeServiceProvider::class,
        OWC\Persberichten\Taxonomy\TaxonomyServiceProvider::class,
        OWC\Persberichten\Settings\SettingsServiceProvider::class,
    ],

    /**
     * Dependencies upon which the plugin relies.
     *
     * Required: type, label
     * Optional: message
     *
     * Type: plugin
     * - Required: file
     * - Optional: version
     *
     * Type: class
     * - Required: name
     */
    'dependencies' => [
        [
            'type'    => 'plugin',
            'label'   => 'RWMB Metabox',
            'version' => '4.14.0',
            'file'    => 'meta-box/meta-box.php',
        ],
        [
            'type'    => 'plugin',
            'label'   => 'Meta Box Group',
            'version' => '1.2.14',
            'file'    => 'metabox-group/meta-box-group.php',
        ],
    ]
];
