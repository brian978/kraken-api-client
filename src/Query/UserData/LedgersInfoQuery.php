<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\UserData;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class LedgersInfoQuery extends Query
{
    use PrivateQuery;

    protected string $resource = 'Ledgers';

    public const TYPE_ALL = 'all';
    public const TYPE_DEPOSIT = 'deposit';
    public const TYPE_WITHDRAWAL = 'withdrawal';
    public const TYPE_TRADE = 'trade';
    public const TYPE_MARGIN = 'margin';

    private static array $typeList = [
        self::TYPE_ALL,
        self::TYPE_DEPOSIT,
        self::TYPE_WITHDRAWAL,
        self::TYPE_TRADE,
        self::TYPE_MARGIN
    ];

    /**
     * Comma delimited list of assets to restrict output to
     *
     * @var string
     */
    protected string $asset = 'all';

    /**
     * Asset class
     *
     * @var string
     */
    protected string $assetClass = 'currency';

    /**
     * Type of ledger to retrieve
     *
     * @var string
     */
    protected string $type = self::TYPE_ALL;

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

    public function setAsset(string $asset): LedgersInfoQuery
    {
        $this->asset = $asset;
        return $this;
    }

    public function setAssetClass(string $assetClass): LedgersInfoQuery
    {
        $this->assetClass = $assetClass;
        return $this;
    }

    public function setType(string $type): LedgersInfoQuery
    {
        if (!in_array($type, static::$typeList)) {
            throw new \InvalidArgumentException('Invalid ledger type provided');
        }

        $this->type = $type;
        return $this;
    }

    public function setStart(int $start): LedgersInfoQuery
    {
        $this->start = $start;
        return $this;
    }

    public function setEnd(int $end): LedgersInfoQuery
    {
        $this->end = $end;
        return $this;
    }

    public function setOfs(int $ofs): LedgersInfoQuery
    {
        $this->ofs = $ofs;
        return $this;
    }
}
