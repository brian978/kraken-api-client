<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\MarketData;

use KrakenApi\Query\Component\PublicQuery;
use KrakenApi\Query\Query;

class SystemStatusQuery extends Query
{
    use PublicQuery;

    protected string $resource = 'SystemStatus';
}
