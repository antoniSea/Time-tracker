<?php

namespace App\Http\Controllers;

use App\Contracts\CSVReportServiceInterface;
use App\Helpers\CsvReportFileName;
use App\Http\Requests\GenerateReportRequest;
use App\Repositories\TimeEntryRepository;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CSVReportController extends Controller
{
    public function __construct(
        protected TimeEntryRepository       $timeEntryRepository,
        protected CsvReportFileName         $csvFileNameHepler,
        protected CSVReportServiceInterface $csvReportService
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
     * @param CSVReportServiceInterface $csvReportService
     * @return BinaryFileResponse
     */
    public function generateReport(GenerateReportRequest $request, CSVReportServiceInterface $csvReportService): BinaryFileResponse
    {
        return $csvReportService->generateReport($request->validated());
    }

    /**
     * @param GenerateReportRequest $request
     * @param CSVReportServiceInterface $csvReportService
     * @return Response
     */
    public function previewReport(GenerateReportRequest $request, CSVReportServiceInterface $csvReportService): Response
    {
        return Inertia::render('CSVReport/PreviewReport', [
            'fileName' => $csvReportService->previewReport($request->validated()),
        ]);
    }
}
