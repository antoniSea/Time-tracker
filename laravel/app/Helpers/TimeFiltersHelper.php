<?php

namespace App\Helpers;

use App\DTO\TimeFiltersDTO;

class TimeFiltersHelper
{
    public static function filterByTime(TimeFiltersDTO $data, mixed $query, string $startDateField = 'created_at'): mixed
    {
        if ($data->getStartedToDate()) {
            $query->whereDate($startDateField, '>=', $data->getStartedToDate());
        }

        if ($data->getStartedFromDate()) {
            $query->whereDate($startDateField, '<=', $data->getStartedFromDate());
        }

        return $query;
    }
}
