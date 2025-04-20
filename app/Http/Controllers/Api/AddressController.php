<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Http\Resources\AddressCollection;
use App\Http\Requests\AddressStoreRequest;
use App\Http\Requests\AddressUpdateRequest;

class AddressController extends Controller
{
    public function index(Request $request): AddressCollection
    {
        $this->authorize('view-any', Address::class);

        $search = $request->get('search', '');

        $addresses = Address::search($search)
            ->latest()
            ->paginate();

        return new AddressCollection($addresses);
    }

    public function store(AddressStoreRequest $request): AddressResource
    {
        $this->authorize('create', Address::class);

        $validated = $request->validated();

        $address = Address::create($validated);

        return new AddressResource($address);
    }

    public function show(Request $request, Address $address): AddressResource
    {
        $this->authorize('view', $address);

        return new AddressResource($address);
    }

    public function update(
        AddressUpdateRequest $request,
        Address $address
    ): AddressResource {
        $this->authorize('update', $address);

        $validated = $request->validated();

        $address->update($validated);

        return new AddressResource($address);
    }

    public function destroy(Request $request, Address $address): Response
    {
        $this->authorize('delete', $address);

        $address->delete();

        return response()->noContent();
    }
}
