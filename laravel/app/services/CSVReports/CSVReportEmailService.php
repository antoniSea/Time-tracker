<?php

namespace App\services\CSVReports;

use App\Mail\SendCSVReportToPrincipalEmail;
use App\Models\Principal;
use Illuminate\Support\Facades\Mail;

class CSVReportEmailService
{
    public function sendEmailToPrincipal(array $request, object $service): void
    {
        $assetPath = $service->previewReport($request);
        $principal = Principal::findOrFail($request['principal']);

        Mail::to($principal->email)
            ->send(new SendCSVReportToPrincipalEmail($assetPath, $principal));
    }
}
