<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePricipalRequest;
use App\Http\Requests\UpdatePrincipalRequest;
use App\Models\Principal;
use App\Repositories\PrincipalRepository;
use App\services\PrincipalService;
use App\Traits\Searchable;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class PrincipalController extends Controller
{
    use Searchable;

    public function __construct(
        readonly protected PrincipalRepository $principalRepository,
        readonly protected PrincipalService    $principalService,
        readonly protected Principal           $model,
    ) {}

    /**
     * @param CreatePricipalRequest $request
     * @return RedirectResponse
     */
    public function store(CreatePricipalRequest $request): RedirectResponse
    {
        $this->principalService->createPrincipal($request->validated());

        return redirect()->back()->with('success', 'Principal created successfully');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Principal/Index', [
            'principals' => $this->principalService->getPaginatedUserPrincipals($request->user()),
        ]);
    }

    /**
     * @param Request $request
     * @param Principal $principal
     * @return RedirectResponse
     */
    public function markAsMain(Request $request, Principal $principal): RedirectResponse
    {
        $this->principalRepository->updateAllPrincipalsToNotMain($request->user());
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

    /**
     * @param Principal $principal
     * @param UpdatePrincipalRequest $request
     * @return RedirectResponse
     */
    public function update(Principal $principal, UpdatePrincipalRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = $data['password'] ?? $principal->password;

        $principal->update($data);

        return redirect()->route('principals.index');
    }

    /**
     * Destroy the specified resource in storage.
     *
     * @param Principal $principal
     * @return RedirectResponse
     */
    public function destroy(Principal $principal): RedirectResponse
    {
        $principal->delete();

        return redirect()->route('principals.index');
    }
}
