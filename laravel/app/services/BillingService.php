<?php

namespace App\services;

use App\DTO\TimeFiltersDTO;
use App\Helpers\SearchHelper;
use App\Helpers\TimeFiltersHelper;
use App\Models\Bill;
use Illuminate\Pagination\LengthAwarePaginator;

class BillingService
{
    /**
     * @param array $request
     * @return LengthAwarePaginator
     */
    public function getAllUsingTimeFilters(array $request): LengthAwarePaginator
    {
        $query = Bill::with('principal');

        $query = TimeFiltersHelper::filterByTime(
            TimeFiltersDTO::fromRequest($request),
            $query,
        );

        $query = SearchHelper::performSearch($query);

        return $query->paginate(30);
    }
}
