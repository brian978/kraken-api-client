<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\UserData;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class RemoveExportQuery extends Query
{
    use PrivateQuery;

    # Endpoint properties
    protected string $method = 'POST';
    protected string $resource = 'RetrieveExport';
    protected int $weight = 1;

    # Parameter properties
    protected array $required = ['id', 'type'];

    // Types of action on the Export queue
    public const TYPE_CANCEL = 'cancel';
    public const TYPE_DELETE = 'delete';

    /**
     * Report ID to retrieve
     *
     * @var string
     */
    protected string $id;

    /**
     * "delete" can only be used for reports that have already been processed. Use "cancel" for queued or processing reports.
     *
     * @var string
     */
    protected string $type;

    public function setId(string $id): RemoveExportQuery
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $type
     * @return RemoveExportQuery
     */
    public function setType(string $type): RemoveExportQuery
    {
        if (!in_array($type, [self::TYPE_CANCEL, self::TYPE_DELETE])) {
            throw new \InvalidArgumentException('Invalid type value');
        }

        $this->type = $type;
        return $this;
    }
}
