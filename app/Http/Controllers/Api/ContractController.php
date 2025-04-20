<?php

namespace App\Http\Controllers\Api;

use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContractResource;
use App\Http\Resources\ContractCollection;
use App\Http\Requests\ContractStoreRequest;
use App\Http\Requests\ContractUpdateRequest;

class ContractController extends Controller
{
    public function index(Request $request): ContractCollection
    {
        $this->authorize('view-any', Contract::class);

        $search = $request->get('search', '');

        $contracts = Contract::search($search)
            ->latest()
            ->paginate();

        return new ContractCollection($contracts);
    }

    public function store(ContractStoreRequest $request): ContractResource
    {
        $this->authorize('create', Contract::class);

        $validated = $request->validated();

        $contract = Contract::create($validated);

        return new ContractResource($contract);
    }

    public function show(Request $request, Contract $contract): ContractResource
    {
        $this->authorize('view', $contract);

        return new ContractResource($contract);
    }

    public function update(
        ContractUpdateRequest $request,
        Contract $contract
    ): ContractResource {
        $this->authorize('update', $contract);

        $validated = $request->validated();

        $contract->update($validated);

        return new ContractResource($contract);
    }

    public function destroy(Request $request, Contract $contract): Response
    {
        $this->authorize('delete', $contract);

        $contract->delete();

        return response()->noContent();
    }
}
