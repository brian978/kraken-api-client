<?php

declare(strict_types=1);

namespace KrakenApi;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class Client implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private HttpClient $httpClient;

    private string $apiKey;
    private string $apiSecret;
    private int $apiVersion = 0;

    public function __construct(HttpClient $httpClient, string $apiKey, string $apiSecret, int $apiVersion = 0)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->apiVersion = $apiVersion;
    }

    private function enrichPayload(array $payload): array
    {
        $payload['nonce'] = $payload['nonce'] ?? explode(' ', microtime())[1];

        return $payload;
    }

    private function createSignature(string $uri, array $payload): string
    {
        $postData = utf8_encode(http_build_query($payload));
        $encoded = hash('sha256', utf8_encode($payload['nonce'] . $postData), true);
        $message = $uri . $encoded;

        $hmac = hash_hmac('sha512', $message, base64_decode($this->apiSecret), true);

        return base64_encode($hmac);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request(string $uri, array $payload = [], array $headers = []): ResponseInterface
    {
        $this->logger->info('Kraken request URI: ' . $uri);

        $headers['User-Agent'] = 'AcamarKrakenApiClient/' . ClientVersion::VERSION;

        try {
            return $this->httpClient->post($uri, ['form_params' => $payload, 'headers' => $headers]);
        } catch (GuzzleException $e) {
            $this->logger->error('Kraken request failed: ' . $e->getMessage());
            $this->logger->info('Kraken request trace: ' . $e->getTraceAsString());

            throw $e;
        }
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function privateRequest($resource, array $payload = []): ResponseInterface
    {
        $uri = "/$this->apiVersion/private/$resource";
        $payload = $this->enrichPayload($payload);

        $headers = [
            'API-Key' => $this->apiKey,
            'API-Sign' => $this->createSignature($uri, $payload),
            'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8'
        ];

        return $this->request($uri, $payload, $headers);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function publicRequest($resource, array $payload = []): ResponseInterface
    {
        $uri = "/$this->apiVersion/public/$resource";

        return $this->request($uri, $payload);
    }
}
