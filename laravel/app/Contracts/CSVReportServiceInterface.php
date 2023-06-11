<?php

namespace App\Contracts;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface CSVReportServiceInterface
{

    public function generateReport(array $request): BinaryFileResponse;
    public function previewReport(array $request): string;
}
