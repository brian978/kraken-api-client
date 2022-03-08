<?php

declare(strict_types=1);

namespace KrakenApi\RateLimiter;

use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\RateLimiter\LimiterInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\RateLimiter\Storage\StorageInterface;

class RateLimiter implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    # Dependencies
    private StorageInterface $storage;
    private LockFactory $lockFactory;
    private LimiterInterface $limiter;

    # Rate limiter defaults
    private int $maxWeight = 15;
    private float $decayRate = 0.33; // TODO: add ability to customize the decay for higher tiers

    private string $limiterKey;

    public function __construct(StorageInterface $storage, LockFactory $lockFactory)
    {
        $this->storage = $storage;
        $this->lockFactory = $lockFactory;
    }

    public function setLimiterKey(string $limiterKey): self
    {
        $this->limiterKey = $limiterKey;
        return $this;
    }

    public function preventSpam(int $weight): void
    {
        // Public endpoints are rate limited to 1 req / second
        // (covered by the client as the nonce becomes invalid if API is called too quickly)
        if ($weight === 0) {
            return;
        }

        if (!isset($this->limiter)) {
            $this->initialize();
            return;
        }

        do {
            $retry = false;
            $limit = $this->limiter->consume($weight);
            if (false === $limit->isAccepted()) {
                $retryAfterDate = $limit->getRetryAfter()->format('Y-m-d H:i:s');
                $this->logger->warning('Request limit reached. Waiting after ' . $retryAfterDate);

                $limit->wait();
                $retry = true;
            }
        } while (true === $retry);

        $this->logger->debug('Remaining tokens: ' . $limit->getRemainingTokens());
    }

    public function handleReachedRateLimit(ResponseInterface $response): void
    {
        $body = json_decode((string)$response->getBody(), true);

        if (!empty($body['errors']) && ($body['errors'][0] ?? null) === 'EAPI:Rate limit exceeded') {
            $this->preventSpam($this->maxWeight);
        }
    }

    private function initialize(): self
    {
        $config = [
            'id' => 'kraken-api-rate-limiter',
            'policy' => 'token_bucket',
            'limit' => $this->maxWeight,
            'rate' => [
                'interval' => (ceil(1 / $this->decayRate) * $this->maxWeight) . ' seconds',
                'amount' => $this->maxWeight
            ],
        ];

        $limiterWildcard = $this->maxWeight . '-' . str_replace(' ', '', (string)$this->decayRate);

        $factory = new RateLimiterFactory($config, $this->storage, $this->lockFactory);

        $this->limiter = $factory->create('kraken-api-limiter-' . $limiterWildcard . '-' . $this->limiterKey);

        return $this;
    }
}