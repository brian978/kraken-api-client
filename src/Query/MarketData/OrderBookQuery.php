<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\MarketData;

use KrakenApi\Query\Component\PublicQuery;
use KrakenApi\Query\Query;

class OrderBookQuery extends Query
{
    use PublicQuery;

    protected string $resource = 'Depth';

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
     * maximum number of asks/bids
     *
     * @var int
     */
    protected int $count;

    public function setPair(string $pair): OrderBookQuery
    {
        $this->pair = $pair;
        return $this;
    }

    public function setCount(int $count): OrderBookQuery
    {
        $this->count = $count;
        return $this;
    }
}
