<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CalendarEntry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CalendarController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'events' => auth()->user()->calendarEntries,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        CalendarEntry::create($request->all() + ['user_id' => auth()->user()->id, 'start_time' => now(), 'end_time' => now(), 'description' => 'ss', 'pending' => true]);

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function destroy($id): JsonResponse
    {
        CalendarEntry::find($id)->delete();

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function update($id, Request $request): JsonResponse
    {
        CalendarEntry::find($id)->update($request->all());

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function calendarView(): Response
    {
        return Inertia::render('calendar/index');
    }
}
