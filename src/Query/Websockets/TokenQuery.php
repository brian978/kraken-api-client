<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\Websockets;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class TokenQuery extends Query
{
    use PrivateQuery;

    protected string $resource = 'GetWebSocketsToken';
}
