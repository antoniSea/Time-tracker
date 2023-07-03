<?php

namespace App\services;

use App\Enums\Roles\RoleNamesEnum;
use App\Helpers\SearchHelper;
use App\Http\Middleware\Authenticate;
use App\Models\Principal;
use App\Models\User;
use App\Repositories\PrincipalRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PrincipalService
{
    public function __construct(
        protected PrincipalRepository $principalRepository,
    ) {}

    public function createPrincipal(array $request): void
    {
        $principal = Principal::query()->create($request + ['user_id' => auth()->id()]);

        $user = User::query()->create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make(Str::random(40)),
            'principal_id' => $principal->id,
        ]);

        $user->roles()->attach(
            RoleNamesEnum::PRINCIPAL_ID
        );
    }

    public function getPaginatedUserPrincipals(Authenticatable $user): LengthAwarePaginator
    {
        $query = SearchHelper::performSearch($user->principals());

        return $query->paginate(10);
    }
}
