<?php

namespace App\services\CSVReports;

use App\Exports\ExportReport;
use App\Helpers\CsvReportFileName;
use App\Models\Principal;
use App\Repositories\TimeEntryRepository;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CSVReportService
{
    public function __construct(
        protected TimeEntryRepository $timeEntryRepository,
        protected CsvReportFileName   $csvFileNameHepler,
    ) {}

    public function generateReport(Principal $principal, array $request): BinaryFileResponse
    {
        return Excel::download(new ExportReport(
            $this->timeEntryRepository,
            $request,
        ), $this->csvFileNameHepler->generateCsvReportFileName($principal->name), \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * @param array $request
     * @return string
     */
    public function previewReport(array $request): string
    {
        $name = Str::random(40) . '.csv';
        Excel::store(new ExportReport(
            $this->timeEntryRepository,
            $request,
        ), $name, 'public');

        return asset('storage/' . $name);
    }
}
