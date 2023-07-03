<?php

namespace App\Observers;

use App\Models\Principal;
use Illuminate\Support\Facades\Mail;
use App\Mail\InformPrincipalAboutAccountCreationMail;

final class PrincipalObserver
{
    /**
     * Handle the Principal "created" event.
     */
    public function created(Principal $principal): void
    {
        Mail::to($principal->email)
            ->send(new InformPrincipalAboutAccountCreationMail($principal));
    }
}
