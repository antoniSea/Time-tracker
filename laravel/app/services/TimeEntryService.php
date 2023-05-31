<?php

namespace App\services;

use App\DTO\TimeEntries\IndexTimeEntryDTO;
use App\Helpers\GetSelectedPrincipalEntry;
use App\Models\TimeEntry;
use App\Repositories\TimeEntryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\DB;

class TimeEntryService
{
    public function __construct(
        protected readonly TimeEntryRepository       $timeEntryRepository,
        protected readonly GetSelectedPrincipalEntry $getSelectedPrincipalEntry,
    ) {}

    /**
     * Starting timer for time counting
     *
     * @return void
     */
    public function createTimeEntry(): void
    {
        $this->getSelectedPrincipalEntry->__invoke()->timeEntries()->create([
            'start_time' => now(),
            'end_time' => now(),
            'pending' => true,
        ]);
    }

    /**
     * Closing timer for time counting
     *
     * @return void
     */
    public function closeTimeEntry(): void
    {
        $timeEntry = $this->timeEntryRepository->getFirstTimeEntryForUserWithPendingStatus(auth()->user());

        $timeEntry->update([
            'end_time' => now(),
            'pending' => false,
        ]);
    }

    /**
     * @return Collection
     */
    public function getOnlyTrashTimeEntriesForUser(): Collection
    {
        return auth()->user()->principals()->first()->timeEntries()->onlyTrashed()->get();
    }

    /**
     * @param int $id
     * @return void
     */
    public function reverseDeletion(int $id): void
    {
        $timeEntry = $this->timeEntryRepository->getDeletedTimeEntryById($id);

        $timeEntry->restore();
    }

    /**
     * @param IndexTimeEntryDTO $timeEntryDTO
     * @return HasManyThrough
     */
    public function getTimeEntriesForUserWhereStatusIsPending(IndexTimeEntryDTO $timeEntryDTO): HasManyThrough
    {
        $query = $this->timeEntryRepository->getAllTimeEntriesForUser(auth()->user());

        if ($timeEntryDTO->getStartedToDate()) {
            $query->whereDate('start_time', '>=', $timeEntryDTO->getStartedToDate());
        }

        if ($timeEntryDTO->getStartedFromDate()) {
            $query->whereDate('start_time', '<=', $timeEntryDTO->getStartedFromDate());
        }

        return $query->with('principal');
    }

    /**
     * @return void
     */
    public function reverseDeletionForAllEntries(): void
    {
        $timeEntries = $this->timeEntryRepository->getDeletedTimeEntriesForUser(auth()->user());

        foreach ($timeEntries as $timeEntry) {
            $timeEntry->restore();
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function hardDelete(int $id): void
    {
        $timeEntry = $this->timeEntryRepository->getDeletedTimeEntryById($id);
        $timeEntry->forceDelete();
    }
}
