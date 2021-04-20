<?php

return [

    // Service Providers.
    'providers'    => [
        // Global providers.
        OWC\OpenPub\Persberichten\Laposta\LapostaServiceProvider::class,
        OWC\OpenPub\Persberichten\RestAPI\RestAPIServiceProvider::class,
        OWC\OpenPub\Persberichten\PostType\PostTypeServiceProvider::class,
        OWC\OpenPub\Persberichten\Taxonomy\TaxonomyServiceProvider::class,
        OWC\OpenPub\Persberichten\Settings\SettingsServiceProvider::class,
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
            'label'   => 'Yard | OpenPub Base',
            'version' => '2.0.0',
            'file'    => 'openpub-base/openpub-base.php',
        ],
    ],
];
