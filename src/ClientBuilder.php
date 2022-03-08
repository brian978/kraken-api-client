<?php

declare(strict_types=1);

namespace KrakenApi;

use Composer\CaBundle\CaBundle;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions as GuzzleRequestOptions;
use KrakenApi\Client as KrakenApiClient;
use KrakenApi\RateLimiter\RateLimiter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\Store\InMemoryStore;
use Symfony\Component\RateLimiter\Storage\InMemoryStorage;

class ClientBuilder implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private string $baseUri = 'https://api.kraken.com';
    private string $apiKey;
    private string $apiSecret;
    private int $apiVersion = 0;

    public function setBaseUri(string $baseUri): ClientBuilder
    {
        $this->baseUri = $baseUri;
        return $this;
    }

    public function setApiKey(string $apiKey): ClientBuilder
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function setApiSecret(string $apiSecret): ClientBuilder
    {
        $this->apiSecret = $apiSecret;
        return $this;
    }

    public function setApiVersion(int $apiVersion): ClientBuilder
    {
        $this->apiVersion = $apiVersion;
        return $this;
    }

    public function build(): Client
    {
        if (!isset($this->logger)) {
            // create a default logger
            $this->logger = new Logger('name');
            $this->logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
        }

        $httpClient = new HttpClient([
            'base_uri' => $this->baseUri,
            GuzzleRequestOptions::VERIFY => CaBundle::getSystemCaRootBundlePath()
        ]);

        $rateLimiter = new RateLimiter(new InMemoryStorage(), new LockFactory(new InMemoryStore()));
        $rateLimiter->setLogger($this->logger);

        $client = new KrakenApiClient($httpClient, $rateLimiter, $this->apiKey, $this->apiSecret, $this->apiVersion);
        $client->setLogger($this->logger);

        return $client;
    }
}
