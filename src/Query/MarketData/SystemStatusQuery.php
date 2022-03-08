<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\MarketData;

use KrakenApi\Query\Component\PublicQuery;
use KrakenApi\Query\Query;

class SystemStatusQuery extends Query
{
    use PublicQuery;

    # Endpoint properties
    protected string $method = 'POST';
    protected string $resource = 'SystemStatus';
    protected int $weight = 0;
}
