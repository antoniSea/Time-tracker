<?php

use App\Http\Controllers\CSVReportController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\TimeEntryController;
use App\Http\Requests\UserSettingController;
use App\Repositories\TimeEntryRepository;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->middleware('roles')->group(function () {
    Route::get('dashboard', function () {
        if (auth()->user()->hasRole('principal')) {
            return redirect()->route('csv-reports.generate-report-form');
        }

        return Inertia::render('Dashboard', [
            'principals' => auth()->user()->principals,
            'timeEntries' => TimeEntryRepository::getTimeEntriesForUserWhereStatusIsPending(auth()->user()),
        ]);
    })->name('dashboard');

    Route::middleware('role:employee')->group(function () {
        Route::prefix('time-entries')->group(function () {
            Route::post('start-timer', [TimeEntryController::class, 'startTimer'])->name('time-entries.start-timer');
            Route::post('close-timer', [TimeEntryController::class, 'closeTimer'])->name('time-entries.close-timer');

            Route::get('/index', [TimeEntryController::class, 'index'])->name('time-entries.index');
            Route::delete('/delete/{timeEntry}', [TimeEntryController::class, 'delete'])->name('time-entries.destroy');
            Route::get('/edit/{timeEntry}', [TimeEntryController::class, 'edit'])->name('time-entries.edit');
            Route::post('/update/{timeEntry}', [TimeEntryController::class, 'update'])->name('time-entries.update');

            Route::get('/deleted', [TimeEntryController::class, 'deletedTimeEntries'])->name('time-entries.deleted');
            Route::post('/reverse-deletion/{id}', [TimeEntryController::class, 'reverseDeletion'])->name('time-entries.reverse-deletion');
            Route::post('/reverse-deletion-for-all-entries', [TimeEntryController::class, 'reverseDeletionForAllEntries'])->name('time-entries.reverse-deletion-for-all-entries');
            Route::delete('/hard-delete/{id}', [TimeEntryController::class, 'hardDelete'])->name('time-entries.hard-delete');
        });

        Route::resource('principals', PrincipalController::class)->names('principals');
        Route::post('/principals/mark-as-main/{principal}', [PrincipalController::class, 'markAsMain'])->name('principals.mark-as-main');

        Route::put('/user-settings/{name}/{value}', [UserSettingController::class, 'update'])->name('user-settings');
    });

    Route::get('/csv-reports', [CSVReportController::class, 'generateReportForm'])->name('csv-reports.generate-report-form');
    Route::post('/csv-reports/generate', [CSVReportController::class, 'generateReport'])->name('csv-reports.store');
    Route::get('/csv-reports/preview', [CSVReportController::class, 'previewReport'])->name('csv-reports.preview');

});
