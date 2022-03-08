<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\MarketData;

use KrakenApi\Query\Component\PublicQuery;
use KrakenApi\Query\Query;

class AssetInfoQuery extends Query
{
    use PublicQuery;

    # Endpoint properties
    protected string $method = 'POST';
    protected string $resource = 'Assets';
    protected int $weight = 0;

    /**
     * Comma delimited list of assets to get info on.
     *
     * Eg:XBT,ETH
     *
     * @var string
     */
    protected string $asset;

    /**
     * Asset class. (optional, default: currency)
     *
     * @var string
     */
    protected string $assetClass = 'currency';

    public function setAsset(string $asset): AssetInfoQuery
    {
        $this->asset = $asset;
        return $this;
    }

    public function setAssetClass(string $assetClass): AssetInfoQuery
    {
        $this->assetClass = $assetClass;
        return $this;
    }
}
