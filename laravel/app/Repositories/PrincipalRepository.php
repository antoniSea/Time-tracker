<?php

namespace App\Repositories;

use App\Models\Principal;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PrincipalRepository
{
    /**
     * @param User $user
     * @return void
     */
    public static function updateAllPrincipalsToNotMain(User $user): void
    {
        Principal::query()->where('user_id', $user->id)->update(['selected_main' => false]);
    }

    /**
     * @param Authenticatable $user
     * @return Principal
     */
    public function getSelectedPrincipal(Authenticatable $user): Principal
    {
        return $user->principals()->where('selected_main', true)->first();
    }
}
