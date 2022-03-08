<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\MarketData;

use KrakenApi\Query\Component\PublicQuery;
use KrakenApi\Query\Query;

class RecentTradesQuery extends Query
{
    use PublicQuery;

    # Endpoint properties
    protected string $method = 'POST';
    protected string $resource = 'Trades';
    protected int $weight = 0;

    # Parameter properties
    protected array $required = ['pair'];

    /**
     * Asset pairs to get data for
     *
     * Eg: XBTUSD
     *
     * @var string
     */
    protected string $pair;

    /**
     * Return committed OHLC data since given ID
     *
     * Example: since=1548111600
     *
     * @var int
     */
    protected int $since;

    public function setPair(string $pair): RecentTradesQuery
    {
        $this->pair = $pair;
        return $this;
    }

    public function setSince(int $since): RecentTradesQuery
    {
        $this->since = $since;
        return $this;
    }


}
