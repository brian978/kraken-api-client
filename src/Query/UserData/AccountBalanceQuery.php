<?php

namespace KrakenApi\Query\UserData;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class AccountBalanceQuery extends Query
{
    use PrivateQuery;

    protected string $resource = 'Balance';
}
