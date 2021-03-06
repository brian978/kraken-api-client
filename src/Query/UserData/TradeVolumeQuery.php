<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\UserData;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class TradeVolumeQuery extends Query
{
    use PrivateQuery;

    # Endpoint properties
    protected string $method = 'POST';
    protected string $resource = 'TradeVolume';
    protected int $weight = 1;

    /**
     * Comma delimited list of asset pairs to get fee info on (optional)
     *
     * @var string
     */
    protected string $pair;

    /**
     * Whether to include fee info in results (optional)
     *
     * @var bool
     */
    protected bool $feeInfo = false;

    public function setPair(string $pair): TradeVolumeQuery
    {
        $this->pair = $pair;
        return $this;
    }

    public function setFeeInfo(bool $feeInfo): TradeVolumeQuery
    {
        $this->feeInfo = $feeInfo;
        return $this;
    }


}
