<?php

use App\Http\Controllers\Api\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', LandingPageController::class)->name('landing-page');

Route::group([], __DIR__ . '/BillingRoutes.php');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->middleware('roles')->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::middleware('role:employee')->group(function () {
        Route::prefix('time-entries')->group(function () {
            Route::group([], __DIR__ . '/TimerRoutes.php');
            Route::group([], __DIR__ . '/TimeEntryRoutes.php');
        });

        Route::group([], __DIR__ . '/PrincipalRoutes.php');

    });

    Route::group([], __DIR__ . '/CSVReportRoutes.php');

    Route::get('calendarView', [CalendarController::class, 'calendarView'])->name('calendarView');
    Route::resource('calendar', CalendarController::class);
});
