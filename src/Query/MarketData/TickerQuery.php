<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\MarketData;

use KrakenApi\Query\Component\PublicQuery;
use KrakenApi\Query\Query;

class TickerQuery extends Query
{
    use PublicQuery;

    protected string $resource = 'Ticker';

    protected array $required = ['pair'];

    /**
     * Asset pairs to get data for
     *
     * Eg: XBTUSD
     *
     * @var string
     */
    protected string $pair;

    public function setPair(string $pair): TickerQuery
    {
        $this->pair = $pair;
        return $this;
    }
}
