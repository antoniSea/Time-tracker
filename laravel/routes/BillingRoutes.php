<?php

use App\Helpers\SearchRouteHelper;
use App\Http\Controllers\BillingController;
use Illuminate\Support\Facades\Route;

Route::get('bills/preview', [BillingController::class, 'preview'])->name('billing.preview');
Route::get('bills/{bill:url_token}/download', [BillingController::class, 'download'])->name('billing.download');
SearchRouteHelper::searchRoutes('bills',BillingController::class, 'billing.');
Route::resource('bills', BillingController::class)->names('billing');
