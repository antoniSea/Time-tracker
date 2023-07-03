<?php

namespace App\Http\Controllers;

use App\Repositories\TimeEntryRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request): Response|RedirectResponse
    {
        if (auth()->user()->hasRole('principal')) {
            return redirect()->route('csv-reports.generate-report-form');
        }

        return Inertia::render('Dashboard', [
            'principals' => auth()->user()->principals,
            'timeEntries' => TimeEntryRepository::getTimeEntriesForUserWhereStatusIsPending(auth()->user()),
        ]);
    }
}
