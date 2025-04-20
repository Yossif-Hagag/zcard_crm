<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\AddressStoreRequest;
use App\Http\Requests\AddressUpdateRequest;
use App\Models\Lead;


class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Address::class);

        $search = $request->get('search', '');

        $addresses = Address::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.addresses.index', compact('addresses', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Address::class);

        return view('app.addresses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Address::class);
    
        $validated = $request->validated();
    
        // Create the address
        $address = Address::create([
            'address' => $validated['address'],
            'flat_number' => $validated['flat_number'],
            'floor' => $validated['floor'],
            'landmark' => $validated['landmark'],
            'state' => $validated['state'],
            'building' => $validated['building'],
            'city' => $validated['city'],
            'lead_id' => $validated['lead_id'],
        ]);


        if (isset($validated['lead_id'])) {
            $lead = Lead::find($validated['lead_id']);
            $lead->addresses()->attach($address->id);
        }
    
        // Redirect back to the lead's show page with a success message
        return redirect()
            ->route('leads.show', $validated['lead_id'])
            ->withSuccess(__('crud.common.created'));
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Request $request, Address $address): View
    {
        $this->authorize('view', $address);

        return view('app.addresses.show', compact('address'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Address $address): View
    {
        $this->authorize('update', $address);

        return view('app.addresses.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        AddressUpdateRequest $request,
        Address $address
    ): RedirectResponse {
        $this->authorize('update', $address);

        $validated = $request->validated();

        $address->update($validated);

        return redirect()
            ->route('addresses.edit', $address)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Address $address
    ): RedirectResponse {
        $this->authorize('delete', $address);

        $address->delete();

        return redirect()
            ->route('addresses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
