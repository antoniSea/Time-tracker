<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class SearchRouteHelper
{
    public static function searchRoutes(string $name, string $controller, string $nameSpace = ''): void
    {
        Route::get($name . '/search', [$controller, 'search'])->name($nameSpace . 'search');
        Route::get($name . '/columns', [$controller, 'getColumns'])->name($nameSpace . 'columns');
    }
}
