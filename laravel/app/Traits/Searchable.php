<?php

namespace App\Traits;

use App\Helpers\SearchHelper;
use Illuminate\Http\JsonResponse;

trait Searchable
{
    /**
     * @return JsonResponse
     */
    public function search(): JsonResponse
    {
        $results = SearchHelper::performSearch($this->model)->limit(5)->get();

        return response()->json($results);
    }

    /**
     * @return JsonResponse
     */
    public function getColumns(): JsonResponse
    {
        $columns = $this->model->fillable;

        return response()->json([
            'columns' => $columns,
        ]);
    }
}
