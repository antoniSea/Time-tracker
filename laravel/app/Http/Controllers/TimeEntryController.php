<?php

namespace App\Http\Controllers;

use App\DTO\TimeEntries\IndexTimeEntryDTO;
use App\Http\Requests\IndexTimeEntryRequest;
use App\Http\Requests\UpdateTimeEntryRequest;
use App\Models\TimeEntry;
use App\services\TimeEntryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TimeEntryController extends Controller
{
    public function __construct(
        readonly protected TimeEntryService $timeEntryService
    ) {}

    /**
     * Starting timer for time counting
     *
     * @return JsonResponse
     */
    public function startTimer(): JsonResponse
    {
        $this->timeEntryService->createTimeEntry();

        return response()->json([
            'message' => 'Timer started',
        ]);
    }

    /**
     * Closing timer for time counting
     *
     * @return JsonResponse
     */
    public function closeTimer(): JsonResponse
    {
        $this->timeEntryService->closeTimeEntry();

        return response()->json([
            'message' => 'Timer closed',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexTimeEntryRequest $request
     * @return Response
     */
    public function index(IndexTimeEntryRequest $request): Response
    {
        $query = $this->timeEntryService->getTimeEntriesForUserWhereStatusIsPending(
            IndexTimeEntryDTO::fromRequest($request->validated())
        );

        $timeEntries = $query->paginate(10);

        return Inertia::render('TimeEntries/Index',
            compact('timeEntries', 'request'),
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TimeEntry $timeEntry
     * @return RedirectResponse
     */
    public function delete(TimeEntry $timeEntry): RedirectResponse
    {
        $timeEntry->delete();

        return redirect()->route('time-entries.index')->with('success', 'Time entry deleted');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TimeEntry $timeEntry
     * @return Response
     */
    public function edit(TimeEntry $timeEntry): Response
    {
        return Inertia::render('TimeEntries/Edit', [
            'timeEntry' => $timeEntry,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TimeEntry $timeEntry
     * @param UpdateTimeEntryRequest $request
     * @return RedirectResponse
     */
    public function update(TimeEntry $timeEntry, UpdateTimeEntryRequest $request): RedirectResponse
    {
        $timeEntry->update($request->validated()['timeEntry']);

        return redirect()->route('time-entries.index')->with('success', 'Time entry updated');
    }

    /**
     * Display a listing of the resource only deleted records.
     *
     * @return JsonResponse
     */
    public function deletedTimeEntries(): JsonResponse
    {
        return response()->json([
            'data' => $this->timeEntryService->getOnlyTrashTimeEntriesForUser(),
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function reverseDeletion(int $id): RedirectResponse
    {
        $this->timeEntryService->reverseDeletion($id);

        return redirect()->route('time-entries.index')->with('success', 'Time entry restored');
    }

    /**
     * Delete the specified resource from storage permanently.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function hardDelete(int $id): RedirectResponse
    {
        $this->timeEntryService->hardDelete($id);

        return redirect()->route('time-entries.index')->with('success', 'Time entry deleted permanently');
    }

    /**
     * Restore all deleted records.
     *
     * @return RedirectResponse
     */
    public function reverseDeletionForAllEntries(): RedirectResponse
    {
        $this->timeEntryService->reverseDeletionForAllEntries();

        return redirect()->route('time-entries.index')->with('success', 'All time entries restored');
    }
}
