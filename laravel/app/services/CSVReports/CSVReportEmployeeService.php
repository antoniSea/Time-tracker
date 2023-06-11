<?php

namespace App\services\CSVReports;

use App\Contracts\CSVReportServiceInterface;
use App\Exports\ExportReport;
use App\Helpers\CsvReportFileName;
use App\Models\Principal;
use App\Repositories\TimeEntryRepository;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class CSVReportEmployeeService implements CSVReportServiceInterface
{
    public function __construct(
        protected readonly TimeEntryRepository $timeEntryRepository,
        protected readonly CsvReportFileName   $csvFileNameHepler,
        protected readonly CSVReportService    $csvReportService,
    ) {}

    public function generateReport(array $request): BinaryFileResponse
    {
        $principal = Principal::find(
            $request['principal']
        );

        return $this->csvReportService->generateReport($principal, $request);
    }

    /**
     * @param array $request
     * @return string
     */
    public function previewReport(array $request): string
    {
        return $this->csvReportService->previewReport($request);
    }
}
