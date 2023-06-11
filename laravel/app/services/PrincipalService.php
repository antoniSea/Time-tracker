<?php

namespace App\services;

use App\Enums\Roles\RoleNamesEnum;
use App\Models\Principal;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PrincipalService
{

    public function updatePrincipal()
    {

    }

    public function createPrincipal(array $request): void
    {
        $principal = Principal::query()->create($request + ['user_id' => auth()->id()]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make(Str::random(40)),
            'principal_id' => $principal->id,
        ]);

        $user->roles()->attach(
            RoleNamesEnum::PRINCIPAL_ID
        );
    }
}
