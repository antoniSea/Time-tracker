<?php

use App\Http\Controllers\TimeEntryController;
use Illuminate\Support\Facades\Route;

Route::get('/index', [TimeEntryController::class, 'index'])->name('time-entries.index');
Route::delete('/delete/{timeEntry}', [TimeEntryController::class, 'delete'])->name('time-entries.destroy');
Route::get('/edit/{timeEntry}', [TimeEntryController::class, 'edit'])->name('time-entries.edit');
Route::post('/update/{timeEntry}', [TimeEntryController::class, 'update'])->name('time-entries.update');

Route::get('/deleted', [TimeEntryController::class, 'deletedTimeEntries'])->name('time-entries.deleted');
Route::post('/reverse-deletion/{id}', [TimeEntryController::class, 'reverseDeletion'])->name('time-entries.reverse-deletion');
Route::post('/reverse-deletion-for-all-entries', [TimeEntryController::class, 'reverseDeletionForAllEntries'])->name('time-entries.reverse-deletion-for-all-entries');
Route::delete('/hard-delete/{id}', [TimeEntryController::class, 'hardDelete'])->name('time-entries.hard-delete');
