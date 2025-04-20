<?php

namespace App\Http\Controllers\Api;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\StatusResource;
use App\Http\Resources\StatusCollection;
use App\Http\Requests\StatusStoreRequest;
use App\Http\Requests\StatusUpdateRequest;

class StatusController extends Controller
{
    public function index(Request $request): StatusCollection
    {
        $this->authorize('view-any', Status::class);

        $search = $request->get('search', '');

        $statuses = Status::search($search)
            ->latest()
            ->paginate();

        return new StatusCollection($statuses);
    }

    public function store(StatusStoreRequest $request): StatusResource
    {
        $this->authorize('create', Status::class);

        $validated = $request->validated();

        $status = Status::create($validated);

        return new StatusResource($status);
    }

    public function show(Request $request, Status $status): StatusResource
    {
        $this->authorize('view', $status);

        return new StatusResource($status);
    }

    public function update(
        StatusUpdateRequest $request,
        Status $status
    ): StatusResource {
        $this->authorize('update', $status);

        $validated = $request->validated();

        $status->update($validated);

        return new StatusResource($status);
    }

    public function destroy(Request $request, Status $status): Response
    {
        $this->authorize('delete', $status);

        $status->delete();

        return response()->noContent();
    }
}
