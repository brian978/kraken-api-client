<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\MarketData;

use KrakenApi\Query\Component\PublicQuery;
use KrakenApi\Query\Query;

class TradableAssetQuery extends Query
{
    use PublicQuery;

    # Endpoint properties
    protected string $method = 'POST';
    protected string $resource = 'AssetPairs';
    protected int $weight = 0;

    // Information types
    public const INFO_ALL = 'info';
    public const INFO_LEVERAGE = 'leverage';
    public const INFO_FEES = 'fees';
    public const INFO_MARGIN = 'margin';

    private static array $infoList = [
        self::INFO_ALL,
        self::INFO_LEVERAGE,
        self::INFO_FEES,
        self::INFO_MARGIN
    ];

    /**
     * Asset pairs to get data for
     *
     * Eg: XXBTCZUSD,XETHXXBT
     *
     * @var string
     */
    protected string $pair;

    /**
     * Info to retrieve. (optional)
     *
     * @var string
     */
    protected string $info = 'info';

    public function setPair(string $pair): TradableAssetQuery
    {
        $this->pair = $pair;
        return $this;
    }

    public function setInfo(string $info): TradableAssetQuery
    {
        if (!in_array($info, static::$infoList)) {
            throw new \InvalidArgumentException('Invalid info value');
        }

        $this->info = $info;
        return $this;
    }
}
