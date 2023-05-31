<?php

namespace App\Repositories;

use App\Models\Principal;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PrincipalRepository
{
    /**
     * @return LengthAwarePaginator
     */
    public static function getPaginatedUserPrincipals(): LengthAwarePaginator
    {
        return auth()->user()->principals()->paginate(10);
    }


    /**
     * @return void
     */
    public static function updateAllPrincipalsToNotMain(): void
    {
        Principal::query()->where('user_id', auth()->id())->update(['selected_main' => false]);
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
