<?php

namespace KrakenApi\Query\Component;

use KrakenApi\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * @property-read Client $client
 * @property-read string $method
 * @property-read string $resource
 * @method array payload()
 */
trait PrivateQuery
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function makeRequest(): ResponseInterface
    {
        return $this->client->privateRequest($this->method, $this->resource, $this->payload());
    }
}
