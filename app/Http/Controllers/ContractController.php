<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ContractStoreRequest;
use App\Http\Requests\ContractUpdateRequest;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Contract::class);

        $search = $request->get('search', '');

        $contracts = Contract::query()
        ->when($search, function ($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(5)
        ->withQueryString();
        return view('app.contracts.index', compact('contracts', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Contract::class);

        return view('app.contracts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContractStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Contract::class);

        $validated = $request->validated();

        $contract = Contract::create($validated);

        return redirect()
            ->route('contracts.index', $contract)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Contract $contract): View
    {
        $this->authorize('view', $contract);

        return view('app.contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Contract $contract): View
    {
        $this->authorize('update', $contract);

        return view('app.contracts.edit', compact('contract'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ContractUpdateRequest $request,
        Contract $contract
    ): RedirectResponse {
        $this->authorize('update', $contract);

        $validated = $request->validated();

        $contract->update($validated);

        return redirect()
            ->route('contracts.index', $contract)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Contract $contract
    ): RedirectResponse {
        $this->authorize('delete', $contract);

        $contract->delete();

        return redirect()
            ->route('contracts.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
