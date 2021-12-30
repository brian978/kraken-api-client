<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\UserData;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class OpenPositionsQuery extends Query
{
    use PrivateQuery;

    protected string $resource = 'OpenPositions';

    /**
     * Comma delimited list of transaction IDs to query info about (20 maximum)
     *
     * @var string
     */
    protected string $txId;

    /**
     * Whether to include P&L calculations
     *
     * @var bool
     */
    protected bool $docalcs = false;

    /**
     * Consolidate positions by market/pair
     *
     * @var string
     */
    protected string $consolidation = 'market';

    public function setTxId(string $txId): OPenPositionsQuery
    {
        if (count(explode(',', $txId)) > 20) {
            throw new \InvalidArgumentException('Too many transaction ids!');
        }

        $this->txId = $txId;
        return $this;
    }

    public function setDocalcs(bool $docalcs): OpenPositionsQuery
    {
        $this->docalcs = $docalcs;
        return $this;
    }

    public function setConsolidation(string $consolidation): OpenPositionsQuery
    {
        $this->consolidation = $consolidation;
        return $this;
    }
}
