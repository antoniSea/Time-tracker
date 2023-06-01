<?php

namespace App\Http\Controllers;

use App\Exports\ExportReport;
use App\Helpers\CsvReportFileName;
use App\Http\Requests\GenerateReportRequest;
use App\Models\Principal;
use App\Repositories\TimeEntryRepository;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CSVReportController extends Controller
{
    public function __construct(
        protected TimeEntryRepository $timeEntryRepository,
        protected CsvReportFileName   $csvFileNameHepler,
    ) {}
    /**
     * @return Response
     */
    public function generateReportForm(): Response
    {
        return Inertia::render('CSVReport/GenerateReport', [
            'principals' => auth()->user()->principals,
        ]);
    }

    /**
     * @param GenerateReportRequest $request
     * @return BinaryFileResponse
     */
    public function generateReport(GenerateReportRequest $request): BinaryFileResponse
    {
        $principal = Principal::query()->find(
            $request->validated('principal')
        );

        return Excel::download(new ExportReport(
            $this->timeEntryRepository,
            $request->validated(),
        ), $this->csvFileNameHepler->generateCsvReportFileName($principal->name), \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * @param GenerateReportRequest $request
     * @return Response
     */
    public function previewReport(GenerateReportRequest $request): Response
    {
        $name = Str::random(40) . '.csv';
        Excel::store(new ExportReport(
            $this->timeEntryRepository,
            $request->validated(),
        ), $name, 'public');

        return Inertia::render('CSVReport/PreviewReport', [
            'fileName' => asset('storage/' . $name),
        ]);
    }
}
