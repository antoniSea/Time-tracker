<?php

namespace App\Helpers;

use App\DTO\TimeFiltersDTO;

class TimeFiltersHelper
{
    public static function filterByTime(TimeFiltersDTO $data, mixed $query, string $startDateField = 'created_at'): mixed
    {
        $table = $query->getModel()->getTable();

        if ($data->getStartedToDate()) {
            $query->whereDate("{$table}.{$startDateField}", '>=', $data->getStartedToDate());
        }

        if ($data->getStartedFromDate()) {
            $query->whereDate("{$table}.{$startDateField}", '<=', $data->getStartedFromDate());
        }

        return $query;
    }
}
