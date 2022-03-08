<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\UserData;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class LedgersQuery extends Query
{
    use PrivateQuery;

    # Endpoint properties
    protected string $method = 'POST';
    protected string $resource = 'QueryLedgers';
    protected int $weight = 1;

    /**
     * Whether or not to include trades related to position in output
     *
     * @var bool
     */
    protected bool $trades = false;

    /**
     * Comma delimited list of ledger IDs to query info about (20 maximum)
     *
     * @var string
     */
    protected string $id;

    public function setTrades(bool $trades): LedgersQuery
    {
        $this->trades = $trades;
        return $this;
    }

    public function setId(string $id): LedgersQuery
    {
        if (count(explode(',', $id)) > 20) {
            throw new \InvalidArgumentException('Too many transaction ids!');
        }

        $this->id = $id;
        return $this;
    }
}
