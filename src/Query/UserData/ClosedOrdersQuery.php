<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\UserData;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class ClosedOrdersQuery extends Query
{
    use PrivateQuery;

    # Endpoint properties
    protected string $method = 'POST';
    protected string $resource = 'ClosedOrders';
    protected int $weight = 1;

    /**
     * Whether or not to include trades related to position in output
     *
     * @var bool
     */
    protected bool $trades = false;

    /**
     * Restrict results to given user reference id
     *
     * @var int
     */
    protected int $userRef;

    /**
     * Starting unix timestamp or order tx ID of results (exclusive)
     *
     * @var int
     */
    protected int $start;

    /**
     * Ending unix timestamp or order tx ID of results (inclusive)
     *
     * @var int
     */
    protected int $end;

    /**
     * Result offset for pagination
     *
     * @var int
     */
    protected int $ofs;

    /**
     * Which time to use to search
     *
     * @var string
     */
    protected string $closeTime = 'both';

    public function setTrades(bool $trades): ClosedOrdersQuery
    {
        $this->trades = $trades;
        return $this;
    }

    public function setUserRef(int $userRef): ClosedOrdersQuery
    {
        $this->userRef = $userRef;
        return $this;
    }

    public function setStart(int $start): ClosedOrdersQuery
    {
        $this->start = $start;
        return $this;
    }

    public function setEnd(int $end): ClosedOrdersQuery
    {
        $this->end = $end;
        return $this;
    }

    public function setOfs(int $ofs): ClosedOrdersQuery
    {
        $this->ofs = $ofs;
        return $this;
    }

    public function setCloseTime(string $closeTime): ClosedOrdersQuery
    {
        $this->closeTime = $closeTime;
        return $this;
    }
}
