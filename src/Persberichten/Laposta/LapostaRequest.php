<?php

namespace OWC\Persberichten\Laposta;

class LapostaRequest
{
    public function __construct()
    {
        $this->apiKey = getenv('LAPOSTA_API_KEY');
        $this->apiURL = getenv('LAPOSTA_API_URL');
    }

    public function request(string $endpoint = '', string $method = 'GET', array $body = []): array
    {
        $result = wp_remote_request($this->makeURL($endpoint), $this->makeRequestArgs($method, $body));

        if (is_wp_error($result)) {
            return ['error' => true];
        }

        $body = json_decode($result['body'], true);

        if (!$body) {
            return ['error' => true];
        }

        return $body;
    }

    protected function makeURL(string $endpoint = ''): string
    {
        return sprintf('%s/%s', rtrim($this->apiURL, '/'), $endpoint);
    }

    protected function makeRequestArgs(string $method = 'GET', array $body = []): array
    {
        $headers = [
            'Authorization'    => 'Basic ' . base64_encode($this->apiKey . ':'),
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
