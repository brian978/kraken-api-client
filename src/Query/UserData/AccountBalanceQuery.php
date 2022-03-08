<?php

namespace KrakenApi\Query\UserData;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class AccountBalanceQuery extends Query
{
    use PrivateQuery;

    # Endpoint properties
    protected string $method = 'POST';
    protected string $resource = 'Balance';
    protected int $weight = 1;
}
