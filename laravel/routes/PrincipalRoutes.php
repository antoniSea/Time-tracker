<?php

use App\Helpers\SearchRouteHelper;
use App\Http\Controllers\PrincipalController;
use App\Http\Requests\UserSettingController;
use Illuminate\Support\Facades\Route;

Route::post('/principals/mark-as-main/{principal}', [PrincipalController::class, 'markAsMain'])->name('principals.mark-as-main');
Route::put('/user-settings', [UserSettingController::class, 'update'])->name('user-settings');
SearchRouteHelper::searchRoutes('principals',PrincipalController::class, 'principals.');
Route::resource('principals', PrincipalController::class)->names('principals');
