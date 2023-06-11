<?php

namespace App\Exports;

use App\Repositories\TimeEntryRepository;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportReport implements FromCollection
{
    public const FILE_FORMAT_EXTENDED = '2';

    public function __construct(
        protected TimeEntryRepository $timeEntryRepository,
        protected array               $data,
    ) {}

    public function collection(): Collection
    {
        if ($this->data['fileFormat'] === self::FILE_FORMAT_EXTENDED) {
            return $this->generateExtendedReport();
        }

        return $this->generateStandardReport();
    }

    private function generateStandardReport(): Collection
    {
        $headers = ['Dzień', 'Czas pracy'];

        $timeEntries = $this->getTimeEntries();

        $data = $this->formatStandardData($timeEntries);

        return $this->addHeadersToData($headers, $data);
    }

    private function generateExtendedReport(): Collection
    {
        $headers = ['Czas rozpoczęcia', 'Czas zakończenia', 'Czas pracy'];

        $timeEntries = $this->getTimeEntries();

        $data = $this->formatExtendedData($timeEntries);

        return $this->addHeadersToData($headers, $data);
    }

    private function formatStandardData(Collection $timeEntries): Collection
    {
        $data = $timeEntries->groupBy(function ($timeEntry) {
            return date('Y-m-d', strtotime($timeEntry->start_time));
        })->map(function ($dayEntries) {
            $sum = $this->getSumTimeWorkedInMinutes($dayEntries);
            return $this->formatMinutesToHours($sum);
        });

        $data = $data->map(function ($value, $key) {
            return [
                'Dzień' => $key,
                'Czas pracy' => $value,
            ];
        });

        $sum = $this->getSumTimeWorkedInMinutes($timeEntries);
        $data->push([
            'Dzień' => 'Suma godzin',
            'Czas pracy' => $this->formatMinutesToHours($sum),
        ]);

        return $data;
    }

    private function formatExtendedData(Collection $timeEntries): Collection
    {
        $data = $timeEntries->map(function ($timeEntry) {
            return [
                $timeEntry->start_time,
                $timeEntry->end_time,
                $this->formatMinutesToHours($this->getTimeWorkedInMinutes($timeEntry)),
            ];
        });

        $sum = $this->getSumTimeWorkedInMinutes($timeEntries);
        $data->push([
            'Suma godzin',
            '',
            $this->formatMinutesToHours($sum),
        ]);

        return $data;
    }

    private function formatMinutesToHours(int $minutes): string
    {
        return floor($minutes / 60) . ':' . str_pad($minutes % 60, 2, '0', STR_PAD_LEFT);
    }

    private function getTimeEntries(): Collection
    {
        if ($this->data['fromDate'] && $this->data['toDate']) {
            return $this->timeEntryRepository->getAllTimeEntriesForUserWherePrincipalIdIsWithDates(
                auth()->user(),
                $this->data['principal'],
                $this->data['fromDate'],
                $this->data['toDate']
            );
        }

        return $this->timeEntryRepository->getAllTimeEntriesForUserWherePrincipalIdIs(
            auth()->user(),
            $this->data['principal']
        );
    }

    private function addHeadersToData(array $headers, Collection $data): Collection
    {
        $data->prepend($headers);
        return $data;
    }

    private function getTimeWorkedInMinutes($timeEntry): int
    {
        $start = strtotime($timeEntry->start_time);
        $end = strtotime($timeEntry->end_time);

        $hours = floor(($end - $start) / 3600);
        $minutes = floor(($end - $start) / 60 % 60);

        return $hours * 60 + $minutes;
    }

    private function getSumTimeWorkedInMinutes(Collection $timeEntries): int
    {
        return $timeEntries->reduce(function ($carry, $timeEntry) {
            return $carry + $this->getTimeWorkedInMinutes($timeEntry);
        }, 0);
    }
}
