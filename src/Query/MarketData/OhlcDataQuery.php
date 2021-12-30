<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\MarketData;

use KrakenApi\Query\Component\PublicQuery;
use KrakenApi\Query\Query;

class OhlcDataQuery extends Query
{
    use PublicQuery;

    protected string $resource = 'OHLC';

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
     * Time frame interval in minutes
     *
     * Possible values: 1, 5, 15, 30, 60, 240, 1440, 10080, 21600
     *
     * @var int
     */
    protected int $interval = 1;

    /**
     * Return committed OHLC data since given ID
     *
     * Example: since=1548111600
     *
     * @var int
     */
    protected int $since;

    public function setPair(string $pair): OhlcDataQuery
    {
        $this->pair = $pair;
        return $this;
    }

    public function setInterval(int $interval): OhlcDataQuery
    {
        $this->interval = $interval;
        return $this;
    }

    public function setSince(int $since): OhlcDataQuery
    {
        $this->since = $since;
        return $this;
    }


}
