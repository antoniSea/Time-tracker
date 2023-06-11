<?php

namespace App\services\CSVReports;

use App\Contracts\CSVReportServiceInterface;
use App\Helpers\CsvReportFileName;
use App\Repositories\TimeEntryRepository;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class CSVReportPrincipalService implements CSVReportServiceInterface
{
    public function __construct(
        protected readonly TimeEntryRepository  $timeEntryRepository,
        protected readonly CsvReportFileName    $csvFileNameHepler,
        protected readonly CSVReportService     $csvReportService,
    ) {}

    /**
     * @param array $request
     * @return BinaryFileResponse
     */
    public function generateReport(array $request): BinaryFileResponse
    {
        $principal = auth()->user()->principal;
        $request['principal'] = $principal->id;

        return $this->csvReportService->generateReport($principal, $request);
    }


    /**
     * @param array $request
     * @return string
     */
    public function previewReport(array $request): string
    {
        $request['principal'] = auth()->user()->principal->id;

        return $this->csvReportService->previewReport($request);
    }
}
