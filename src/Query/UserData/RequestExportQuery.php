<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace KrakenApi\Query\UserData;

use KrakenApi\Query\Component\PrivateQuery;
use KrakenApi\Query\Query;

class RequestExportQuery extends Query
{
    use PrivateQuery;

    protected string $resource = 'AddExport';

    protected array $required = ['report', 'description'];

    public const REPORT_TRADES = 'trades';
    public const REPORT_LEDGERS = 'ledgers';

    public const FORMAT_CSV = 'CSV';
    public const FORMAT_TSV = 'TSV';

    /**
     * Type of data to export
     *
     * @var string
     */
    protected string $report;

    /**
     * File format to export
     *
     * @var string
     */
    protected string $format = self::FORMAT_CSV;

    /**
     * Description for the export
     *
     * @var string
     */
    protected string $description;

    /**
     * Comma-delimited list of fields to include
     *
     * trades:  ordertxid, time, ordertype, price, cost, fee, vol, margin, misc, ledgers
     * ledgers: refid, time, type, aclass, asset, amount, fee, balance
     *
     * @var string
     */
    protected string $fields = 'all';

    /**
     * UNIX timestamp for report start time (default 1st of the current month)
     *
     * @var int
     */
    protected int $starttm;

    /**
     * UNIX timestamp for report end time (default now)
     *
     * @var int
     */
    protected int $endtm;

    public function setReport(string $report): RequestExportQuery
    {
        if (!in_array($report, [self::REPORT_TRADES, self::REPORT_LEDGERS])) {
            throw new \InvalidArgumentException('Invalid report value');
        }

        $this->report = $report;
        return $this;
    }

    public function setFormat(string $format): RequestExportQuery
    {
        if (!in_array($format, [self::FORMAT_CSV, self::FORMAT_TSV])) {
            throw new \InvalidArgumentException('Invalid format value');
        }

        $this->format = $format;
        return $this;
    }

    public function setDescription(string $description): RequestExportQuery
    {
        $this->description = $description;
        return $this;
    }

    public function setFields(string $fields): RequestExportQuery
    {
        $this->fields = $fields;
        return $this;
    }

    public function setStart(int $start): RequestExportQuery
    {
        $this->starttm = $start;
        return $this;
    }

    public function setEnd(int $end): RequestExportQuery
    {
        $this->endtm = $end;
        return $this;
    }
}
