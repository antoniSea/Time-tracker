<?php

namespace App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserSettingController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param string $name
     * @param string $value
     * @return RedirectResponse
     */
    public function update(string $name, string $value): RedirectResponse
    {
        $userSetting = auth()->user()->settings()->where('name', $name)->first();
        $userSetting->update(['value' => (boolean)$value]);

        return redirect()->back();
    }
}
