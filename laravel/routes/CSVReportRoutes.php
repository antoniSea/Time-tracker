<?php

use App\Http\Controllers\CSVReportController;
use Illuminate\Support\Facades\Route;


Route::prefix('csv-reports')->name('csv-reports.')->group(function () {
    Route::get('/', [CSVReportController::class, 'generateReportForm'])->name('generate-report-form');
    Route::post('/generate', [CSVReportController::class, 'generateReport'])->name('store');
    Route::get('/preview', [CSVReportController::class, 'previewReport'])->name('preview');
    Route::post('/send-email', [CSVReportController::class, 'sendEmailToPrincipal'])->name('send-email');
});
