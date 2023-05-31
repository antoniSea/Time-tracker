<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePricipalRequest;
use App\Models\Principal;
use App\Repositories\PrincipalRepository;
use App\services\PrincipalService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PrincipalController extends Controller
{
    public function __construct(
        readonly protected PrincipalRepository $principalRepository,
        readonly protected PrincipalService $principalService
    )
    {
    }

    /**
     * @param CreatePricipalRequest $request
     * @return RedirectResponse
     */
    public function store(CreatePricipalRequest $request): RedirectResponse
    {
        Principal::query()->create($request->validated() + ['user_id' => auth()->id()]);

        return redirect()->back()->with('success', 'Principal created successfully');
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Principal/Index', [
            'principals' => $this->principalRepository->getPaginatedUserPrincipals(),
        ]);
    }

    /**
     * @param Principal $principal
     * @return RedirectResponse
     */
    public function markAsMain(Principal $principal): RedirectResponse
    {
        $this->principalRepository->updateAllPrincipalsToNotMain();
        $principal->update(['selected_main' => true]);

        return redirect()->route('principals.index');
    }

    /**
     * @param Principal $principal
     * @return Response
     */
    public function edit(Principal $principal): Response
    {
        return Inertia::render('Principal/Edit', [
            'principal' => $principal,
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Principal/Create');
    }

    public function update(Principal $principal, CreatePricipalRequest $request): RedirectResponse
    {
        $principal->update($request->validated());

        return redirect()->route('principals.index');
    }
}
