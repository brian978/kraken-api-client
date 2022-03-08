<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\UserData;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class OrdersInfoQuery extends Query
{
    use PrivateQuery;

    # Endpoint properties
    protected string $method = 'POST';
    protected string $resource = 'QueryOrders';
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
     * Comma delimited list of transaction IDs to query info about (20 maximum)
     *
     * @var string
     */
    protected string $txId;

    public function setTrades(bool $trades): OrdersInfoQuery
    {
        $this->trades = $trades;
        return $this;
    }

    public function setUserRef(int $userRef): OrdersInfoQuery
    {
        $this->userRef = $userRef;
        return $this;
    }

    public function setTxId(string $txId): OrdersInfoQuery
    {
        if (count(explode(',', $txId)) > 20) {
            throw new \InvalidArgumentException('Too many transaction ids!');
        }

        $this->txId = $txId;
        return $this;
    }
}
