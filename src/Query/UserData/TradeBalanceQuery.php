<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\UserData;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class TradeBalanceQuery extends Query
{
    use PrivateQuery;

    # Endpoint properties
    protected string $method = 'POST';
    protected string $resource = 'TradeBalance';
    protected int $weight = 1;

    /**
     * Base asset used to determine balance
     *
     * @var string
     */
    protected string $asset;

    public function setAsset(string $asset): TradeBalanceQuery
    {
        $this->asset = $asset;
        return $this;
    }
}
