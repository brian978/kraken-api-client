<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\UserData;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class OpenOrdersQuery extends Query
{
    use PrivateQuery;

    # Endpoint properties
    protected string $method = 'POST';
    protected string $resource = 'OpenOrders';
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

    public function setTrades(bool $trades): OpenOrdersQuery
    {
        $this->trades = $trades;
        return $this;
    }

    public function setUserRef(int $userRef): OpenOrdersQuery
    {
        $this->userRef = $userRef;
        return $this;
    }
}
