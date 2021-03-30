<?php

namespace OWC\OpenPub\Persberichten\RestAPI;

use OWC\OpenPub\Persberichten\Foundation\ServiceProvider;
use OWC\OpenPub\Persberichten\RestAPI\Controllers\PersberichtenController;
use WP_REST_Server;

class RestAPIServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    private $namespace = 'owc/openpub/v1';

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->plugin->loader->addFilter('rest_api_init', $this, 'registerRoutes');
        $this->plugin->loader->addFilter('owc/config-expander/rest-api/whitelist', [$this, 'whitelist'], 10, 1);

        // $this->registerModelFields();
    }

    public function registerRoutes()
    {
        register_rest_route($this->namespace, 'persberichten', [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [new PersberichtenController($this->plugin), 'getItems'],
            'permission_callback' => '__return_true',
        ]);
    }

    /**
     * Whitelist endpoints within Config Expander.
     *
     * @param array $whitelist
     * @return array
     */
    public function whitelist(array $whitelist): array
    {
        // Remove default root endpoint
        if (!empty($whitelist['wp/v2'])) {
            unset($whitelist['wp/v2']);
        }

        if (empty($whitelist[$this->namespace])) {
            $whitelist[$this->namespace] = [
                'endpoint_stub' => '/' . $this->namespace,
                'methods'       => ['GET'],
            ];
        }

        return $whitelist;
    }
}
