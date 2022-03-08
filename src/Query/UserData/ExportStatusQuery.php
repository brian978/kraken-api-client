<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\UserData;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class ExportStatusQuery extends Query
{
    use PrivateQuery;

    # Endpoint properties
    protected string $method = 'POST';
    protected string $resource = 'ExportStatus';
    protected int $weight = 1;

    # Parameter properties
    protected array $required = ['report'];

    // Types of reports
    public const REPORT_TRADES = 'trades';
    public const REPORT_LEDGERS = 'ledgers';

    /**
     * Type of data to export
     *
     * @var string
     */
    protected string $report;

    public function setReport(string $report): ExportStatusQuery
    {
        if (!in_array($report, [self::REPORT_TRADES, self::REPORT_LEDGERS])) {
            throw new \InvalidArgumentException('Invalid report value');
        }

        $this->report = $report;
        return $this;
    }
}
