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
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        foreach ($request->toArray() as $request) {
            $userSetting = auth()->user()->settings()->where('name', $request['name'])->first();

            if (!empty($userSetting)) {
                $userSetting->update(['value' => $request['value']]);
                continue;
            }

            auth()->user()->settings()->create(['name' => $request['name'],'value' => $request['value']]);
        }

        return redirect()->back();
    }
}
