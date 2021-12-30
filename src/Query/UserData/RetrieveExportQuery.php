<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\UserData;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class RetrieveExportQuery extends Query
{
    use PrivateQuery;

    protected string $resource = 'RetrieveExport';

    protected array $required = ['id'];

    /**
     * Report ID to retrieve
     *
     * @var string
     */
    protected string $id;

    public function setId(string $id): RetrieveExportQuery
    {
        $this->id = $id;
        return $this;
    }
}
