<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\UserData;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class TradesInfoQuery extends Query
{
    use PrivateQuery;

    protected string $resource = 'QueryOrders';

    /**
     * Whether or not to include trades related to position in output
     *
     * @var bool
     */
    protected bool $trades = false;

    /**
     * Comma delimited list of transaction IDs to query info about (20 maximum)
     *
     * @var string
     */
    protected string $txId;

    public function setTrades(bool $trades): TradesInfoQuery
    {
        $this->trades = $trades;
        return $this;
    }

    public function setTxId(string $txId): TradesInfoQuery
    {
        if (count(explode(',', $txId)) > 20) {
            throw new \InvalidArgumentException('Too many transaction ids!');
        }

        $this->txId = $txId;
        return $this;
    }
}
