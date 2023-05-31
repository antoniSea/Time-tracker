<?php

namespace App\Helpers;

use App\Models\Principal;
use App\Repositories\PrincipalRepository;

class GetSelectedPrincipalEntry
{
    public function __construct(
        protected readonly PrincipalRepository $principalRepository,
    ) {}

    /**
     * @return Principal
     */
    public function __invoke(): Principal
    {
        return $this->principalRepository->getSelectedPrincipal(auth()->user());
    }
}
