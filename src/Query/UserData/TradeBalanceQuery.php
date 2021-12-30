<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\UserData;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class TradeBalanceQuery extends Query
{
    use PrivateQuery;

    protected string $resource = 'TradeBalance';

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
