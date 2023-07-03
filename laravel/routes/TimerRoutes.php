<?php

use App\Http\Controllers\TimeEntryController;
use Illuminate\Support\Facades\Route;

Route::post('start-timer', [TimeEntryController::class, 'startTimer'])->name('time-entries.start-timer');
Route::post('close-timer', [TimeEntryController::class, 'closeTimer'])->name('time-entries.close-timer');
