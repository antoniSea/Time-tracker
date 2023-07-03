<?php

namespace App\services;

use App\DTO\TimeFiltersDTO;
use App\Helpers\GetSelectedPrincipalEntry;
use App\Helpers\SearchHelper;
use App\Helpers\TimeFiltersHelper;
use App\Repositories\TimeEntryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Pagination\LengthAwarePaginator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

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
     * @param TimeFiltersDTO $data
     * @return LengthAwarePaginator
     */
    public function getTimeEntriesForUserWhereStatusIsPending(TimeFiltersDTO $data): LengthAwarePaginator
    {
        $query = $this
            ->timeEntryRepository
            ->getAllTimeEntriesForUser(auth()->user());

        $query = TimeFiltersHelper::filterByTime($data, $query);

        return $query
            ->with('principal')
            ->paginate(10);
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
