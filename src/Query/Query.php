<?php

declare(strict_types=1);

namespace KrakenApi\Query;

use GuzzleHttp\Exception\GuzzleException;
use KrakenApi\Client;
use KrakenApi\Query\Exception\ResponseException;
use Psr\Http\Message\ResponseInterface;

abstract class Query implements QueryInterface
{
    protected Client $client;

    # Endpoint properties
    protected string $method;
    protected string $resource;
    protected int $weight;

    # Parameter properties
    protected array $required = [];

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    abstract protected function makeRequest(): ResponseInterface;

    /**
     * @param \KrakenApi\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;

        if (!isset($this->method)) {
            throw new \RuntimeException('Query method not set!');
        }

        if (!isset($this->resource)) {
            throw new \RuntimeException('Query resource not set!');
        }

        if (!isset($this->weight)) {
            throw new \RuntimeException('Query weight not set!');
        }

        $this->client->setRequestWeight($this->weight);
    }

    protected function payload(): array
    {
        $payload = get_object_vars($this);

        unset($payload['client'], $payload['required'], $payload['resource']);

        foreach ($this->required as $item) {
            if (!isset($payload[$item])) {
                throw new \RuntimeException(
                    'Mandatory parameter not found: ' . $item
                );
            }
        }

        return $payload;
    }

    public function execute(): array
    {
        $result = [];

        try {
            $response = $this->makeRequest();
            $body = json_decode((string)$response->getBody(), true);

            if (!empty($body['error'])) {
                throw new ResponseException($body['error'], $response->getStatusCode());
            }

            $result = $body['result'];
        } catch (GuzzleException $e) {
            // Logging is handled in the client
        }

        return $result;
    }
}
