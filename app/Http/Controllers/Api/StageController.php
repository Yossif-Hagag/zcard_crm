<?php

namespace App\Http\Controllers\Api;

use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\StageResource;
use App\Http\Resources\StageCollection;
use App\Http\Requests\StageStoreRequest;
use App\Http\Requests\StageUpdateRequest;

class StageController extends Controller
{
    public function index(Request $request): StageCollection
    {
        $this->authorize('view-any', Stage::class);

        $search = $request->get('search', '');

        $stages = Stage::search($search)
            ->latest()
            ->paginate();

        return new StageCollection($stages);
    }

    public function store(StageStoreRequest $request): StageResource
    {
        $this->authorize('create', Stage::class);

        $validated = $request->validated();

        $stage = Stage::create($validated);

        return new StageResource($stage);
    }

    public function show(Request $request, Stage $stage): StageResource
    {
        $this->authorize('view', $stage);

        return new StageResource($stage);
    }

    public function update(
        StageUpdateRequest $request,
        Stage $stage
    ): StageResource {
        $this->authorize('update', $stage);

        $validated = $request->validated();

        $stage->update($validated);

        return new StageResource($stage);
    }

    public function destroy(Request $request, Stage $stage): Response
    {
        $this->authorize('delete', $stage);

        $stage->delete();

        return response()->noContent();
    }
}
