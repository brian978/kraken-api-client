<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\UserData;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class TradesHistoryQuery extends Query
{
    use PrivateQuery;

    # Endpoint properties
    protected string $method = 'POST';
    protected string $resource = 'TradesHistory';
    protected int $weight = 2;

    // Types of trades to query
    public const TYPE_ALL = 'all';
    public const TYPE_ANY = 'any position';
    public const TYPE_CLOSED = 'closed position';
    public const TYPE_CLOSING = 'closing position';
    public const TYPE_NONE = 'no position';

    private static array $typeList = [
        self::TYPE_ALL,
        self::TYPE_ANY,
        self::TYPE_CLOSED,
        self::TYPE_CLOSING,
        self::TYPE_NONE
    ];

    /**
     * Type of trade
     *
     * Enum: all, any position, closed position, closing position, no position
     *
     * @var string
     */
    protected string $type = self::TYPE_ALL;

    /**
     * Whether to include trades related to position in output
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
     * @param string $type
     * @return TradesHistoryQuery
     */
    public function setType(string $type): TradesHistoryQuery
    {
        if (!in_array($type, static::$typeList)) {
            throw new \InvalidArgumentException('Invalid trade type provided');
        }

        $this->type = $type;
        return $this;
    }

    public function setTrades(bool $trades): TradesHistoryQuery
    {
        $this->trades = $trades;
        return $this;
    }

    public function setUserRef(int $userRef): TradesHistoryQuery
    {
        $this->userRef = $userRef;
        return $this;
    }

    public function setStart(int $start): TradesHistoryQuery
    {
        $this->start = $start;
        return $this;
    }

    public function setEnd(int $end): TradesHistoryQuery
    {
        $this->end = $end;
        return $this;
    }

    public function setOfs(int $ofs): TradesHistoryQuery
    {
        $this->ofs = $ofs;
        return $this;
    }
}
