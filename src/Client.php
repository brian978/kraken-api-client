<?php

declare(strict_types=1);

namespace KrakenApi;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use KrakenApi\RateLimiter\RateLimiter;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class Client implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private HttpClient $httpClient;
    private RateLimiter $rateLimiter;

    # Endpoint access properties
    private string $apiKey;
    private string $apiSecret;
    private int $apiVersion;

    # Rate limiter properties
    private int $requestWeight;

    public function __construct(
        HttpClient $httpClient,
        RateLimiter $rateLimiter,
        string $apiKey,
        string $apiSecret,
        int $apiVersion = 0
    ) {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->apiVersion = $apiVersion;

        $this->rateLimiter = $rateLimiter;
        $this->rateLimiter->setLimiterKey(base64_encode($this->apiKey));
    }

    public function setRequestWeight(int $requestWeight): self
    {
        $this->requestWeight = $requestWeight;
        return $this;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function publicRequest(string $method, string $resource, array $payload = []): ResponseInterface
    {
        $uri = "/$this->apiVersion/public/$resource";

        return $this->request($method, $uri, $payload);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function privateRequest(string $method, string $resource, array $payload = []): ResponseInterface
    {
        $uri = "/$this->apiVersion/private/$resource";

        $headers = [
            'API-Key' => $this->apiKey,
            'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8'
        ];

        return $this->request($method, $uri, $payload, $headers);
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
    private function request(string $method, string $uri, array $payload = [], array $headers = []): ResponseInterface
    {
        $this->logger->debug('Kraken request URI: ' . $uri);

        $this->rateLimiter->preventSpam($this->requestWeight);

        if ($this->isPrivateRequest($headers)) {
            $payload = $this->enrichPayload($payload);
            $headers['API-Sign'] = $this->createSignature($uri, $payload);
        }

        return $this->makeRequest($method, $uri, $this->prepareOptions($method, $payload, $headers));
    }

    private function isPrivateRequest(array $headers): bool
    {
        return isset($headers['API-Key']);
    }

    private function enrichPayload(array $payload): array
    {
        $payload['nonce'] = $payload['nonce'] ?? explode(' ', microtime())[1];

        return $payload;
    }

    private function prepareOptions(string $method, array $payload = [], array $headers = []): array
    {
        $headers['User-Agent'] = 'AcamarKrakenApiClient/' . ClientVersion::VERSION;
        $options = ['headers' => $headers];

        if ('GET' === $method) {
            $options['query'] = $payload;
        } else {
            $options['form_params'] = $payload;
        }

        return $options;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function makeRequest(string $method, string $uri, array $options): ResponseInterface
    {
        $this->logger->debug('Kraken request $options: ' . serialize($options));

        try {
            $response = $this->httpClient->request($method, $uri, $options);
            if ($this->isRateLimitReached($response)) {
                $this->rateLimiter->preventSpam($this->requestWeight);
            }

            sleep(1); // Prevent public endpoints spam & ensure that nonce stays valid

            return $response;
        } catch (RequestException $e) {
            $this->logger->error('Kraken request failed: ' . $e->getMessage());
            $this->logger->debug('Kraken request trace: ' . $e->getTraceAsString());

            $response = $e->getResponse();

            throw $e;
        } finally {
            // Rate limiter should be synced with what the API is reporting in order to prevent rate limit hits
            $this->rateLimiter->handleReachedRateLimit($response);

            if ($this->isRateLimitReached($response)) {
                $this->rateLimiter->preventSpam($this->requestWeight);
            }
        }
    }

    private function isRateLimitReached(ResponseInterface $response): bool
    {
        $body = json_decode((string)$response->getBody(), true);

        if (!empty($body['errors']) && ($body['errors'][0] ?? null) === 'EAPI:Rate limit exceeded') {
            $this->logger->error('Rate limit reached');
            return true;
        }

        return false;
    }
}
