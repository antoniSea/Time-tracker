<?php

namespace App\Helpers;

use Illuminate\Database\QueryException;

class SearchHelper
{
    const defaultColumn = 'name';

    /**
     * @param mixed $query
     * @param string|null $column
     * @return mixed
     */
    public static function performSearch(mixed $query, string $column = null): mixed
    {
        return request()->search
           ? $query->where(
               $column ?? request()->column ?? static::defaultColumn,
               'like',
               '%' . request()->search . '%'
           )
           : $query;
    }
}
