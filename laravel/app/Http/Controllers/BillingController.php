<?php

namespace App\Http\Controllers;

use App\DTO\Bills\InvoiceDTO;
use App\Http\Requests\CreateBillRequest;
use App\Models\Bill;
use App\Models\Principal;
use App\services\BillingService;
use App\Traits\Searchable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
class BillingController extends Controller
{
    use Searchable;

    public function __construct(
        protected readonly BillingService $billingService,
        public readonly  Bill $model,
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $bills = $this->billingService->getAllUsingTimeFilters($request->toArray());

        return Inertia::render('Billing/Index', compact('request', 'bills'));
    }

    /**
     * Display a creation form.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Billing/Create', [
            'principals' => Principal::all(),
        ]);
    }

    /**
     * @param CreateBillRequest $request
     * @return RedirectResponse
     */
    public function store(CreateBillRequest $request): RedirectResponse
    {
        Bill::create(
            $request->validated()
        );

        return redirect()->route('billing.index');
    }

    /**
     * @param CreateBillRequest $request
     * @return \Illuminate\Http\Response
     */
    public function preview(CreateBillRequest $request): \Illuminate\Http\Response
    {
        $data = $request->validated();

        return Pdf::loadView('pdf.invoice', [
            'invoice' => InvoiceDTO::fromRequest($data),
            'user' => $request->user(),
            'principal' => Principal::find($data['principal_id']),
        ])->stream('invoice.pdf');
    }

    /**
     * @param Bill $bill
     * @return \Illuminate\Http\Response
     */
    public function download(Bill $bill): \Illuminate\Http\Response
    {
        return Pdf::loadView('pdf.invoice', [
            'invoice' => InvoiceDTO::fromBill($bill),
            'user' => auth()->user(),
            'principal' => $bill->principal,
        ])->stream('invoice.pdf');
    }

    /**
     * @param Bill $bill
     * @return Response
     */
    public function edit(Bill $bill): Response
    {
        return Inertia::render('Billing/Edit', [
            'principals' => auth()->user()->principals,
            'bill' => $bill,
        ]);
    }

    /**
     * @param Bill $bill
     * @param CreateBillRequest $request
     * @return RedirectResponse
     */
    public function update(Bill $bill, CreateBillRequest $request): RedirectResponse
    {
        $bill->update($request->validated());

        return redirect()->route('billing.index');
    }

    /**
     * @param Bill $bill
     * @return RedirectResponse
     */
    public function destroy(Bill $bill): RedirectResponse
    {
        $bill->delete();

        return redirect()->back();
    }
}
