<?php

namespace OWC\Persberichten\Laposta;

use OWC\Persberichten\Exceptions\LapostaRequestException;
use OWC\Persberichten\Settings\SettingsPageOptions;

class LapostaRequest
{
    /**
     * Settings defined on settings page
     *
     * @var SettingsPageOptions
     */
    protected $settings;

    public function __construct(SettingsPageOptions $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Make a request to Laposta API.
     *
     * @param string $endpoint
     * @param string $method
     * @param array $body
     * 
     * @throws LapostaRequestException
     * @return array
     */
    public function request(string $endpoint = '', string $method = 'GET', array $body = []): array
    {
        $result = wp_remote_request($this->makeURL($endpoint), $this->makeRequestArgs($method, $body));

        if (is_wp_error($result)) {
            throw new LapostaRequestException('Something went wrong with the Laposta request');
        }

        $body = json_decode($result['body'], true);

        if (!$body) {
            throw new LapostaRequestException('Something went wrong with decoding the Laposta response body');
        }

        if (isset($body['error']['message'])) {
            throw new LapostaRequestException($body['error']['message']);
        }

        return $body;
    }

    protected function makeURL(string $endpoint = ''): string
    {
        return sprintf('%s/%s', rtrim($this->settings->getApiURL(), '/'), $endpoint);
    }

    protected function makeRequestArgs(string $method = 'GET', array $body = []): array
    {
        $headers = [
            'Authorization'    => 'Basic ' . base64_encode($this->settings->getApiKey() . ':'),
            'Content-Type'     => 'application/x-www-form-urlencoded',
            'Accept'           => 'application/json',
        ];

        return [
            'method'  => $method,
            'headers' => $headers,
            'body'    => $body
        ];
    }
}
