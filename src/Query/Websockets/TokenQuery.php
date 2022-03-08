<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\Websockets;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class TokenQuery extends Query
{
    use PrivateQuery;

    # Endpoint properties
    protected string $method = 'POST';
    protected string $resource = 'GetWebSocketsToken';
    protected int $weight = 1;
}
