<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class LandingPageController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('LandingPage', [
            'user' => auth()->user()
        ]);
    }
}
