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
    'dependencies' => [],
];
