<?php

namespace KrakenApi\Query\Component;

use KrakenApi\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * @property-read Client $client
 * @property-read string $resource
 * @method array payload()
 */
trait PublicQuery
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function makeRequest(): ResponseInterface
    {
        return $this->client->publicRequest($this->resource, $this->payload());
    }
}
