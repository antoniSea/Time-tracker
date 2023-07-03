<?php

namespace App\Http\Controllers;

use App\Contracts\CSVReportServiceInterface;
use App\Helpers\CsvReportFileName;
use App\Http\Requests\GenerateReportRequest;
use App\Repositories\TimeEntryRepository;
use App\services\CSVReports\CSVReportEmailService;
use App\services\CSVReports\CSVReportEmployeeService;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CSVReportController extends Controller
{
    public function __construct(
        protected readonly TimeEntryRepository       $timeEntryRepository,
        protected readonly CsvReportFileName         $csvFileNameHelper,
        protected readonly CSVReportServiceInterface $csvReportService,
        protected readonly CSVReportEmailService     $csvReportEmailService,
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

    public function sendEmailToPrincipal(GenerateReportRequest $request, CSVReportEmployeeService $CSVReportEmployeeService): JsonResponse
    {
        $this->csvReportEmailService->sendEmailToPrincipal(
            $request->validated(),
            $CSVReportEmployeeService,
        );

        return response()->json([
            'message' => 'Email sent successfuly',
        ]);
    }
}
