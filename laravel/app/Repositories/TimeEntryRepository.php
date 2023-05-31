<?php

namespace App\Repositories;

use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TimeEntryRepository
{
    /**
     * Get first time entry for user
     *
     * @param User|Authenticatable $user
     * @return TimeEntry
     */
    public static function getFirstTimeEntryForUserWithPendingStatus(User|Authenticatable $user): TimeEntry
    {
        return $user->principals()
            ->whereHas('timeEntries', function ($query) {
                $query->where('pending', true);
            })
            ->first()
            ->timeEntries()
            ->where('pending', true)
            ->first();
    }

    /**
     * @param User|Authenticatable $user
     * @return Collection
     */
    public static function getTimeEntriesForUserWhereStatusIsPending(User|Authenticatable $user): Collection
    {
        $timeEntries = $user->principals()
            ->whereHas('timeEntries', function ($query) {
                $query->where('pending', true);
            })
            ->with(['timeEntries' => function ($query) {
                $query->where('pending', true);
            }])
            ->get()
            ->pluck('timeEntries')
            ->flatten();

        foreach ($timeEntries as $timeEntry) {
            $timeEntry->timeSpent = now()->diffInSeconds($timeEntry->start_time);
        }

        return $timeEntries;
    }

    /**
     * @param int $id
     * @return Model
     */
    public static function getDeletedTimeEntryById(int $id): Model
    {
        return TimeEntry::onlyTrashed()->where('id', $id)->first();
    }

    /**
     * @param Authenticatable|null $user
     * @return mixed
     */
    public function getDeletedTimeEntriesForUser(?Authenticatable $user): Collection
    {
        return $user->principals()->first()->timeEntries()->onlyTrashed()->get();
    }

    /**
     * @param Authenticatable|null $user
     * @return mixed
     */
    public function getAllTimeEntriesForUser(?Authenticatable $user): mixed
    {
        return $timeEntries = $user->timeEntries();
    }
}
