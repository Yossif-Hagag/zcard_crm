<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StageStoreRequest;
use App\Http\Requests\StageUpdateRequest;

class StageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Stage::class);

        $search = $request->get('search', '');

        $stages = Stage::query()
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.stages.index', compact('stages', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Stage::class);

        return view('app.stages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StageStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Stage::class);

        $validated = $request->validated();

        $stage = Stage::create($validated);

        return redirect()
            ->route('stages.index', $stage)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Stage $stage): View
    {
        $this->authorize('view', $stage);

        return view('app.stages.show', compact('stage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Stage $stage): View
    {
        $this->authorize('update', $stage);

        return view('app.stages.edit', compact('stage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        StageUpdateRequest $request,
        Stage $stage
    ): RedirectResponse {
        $this->authorize('update', $stage);

        $validated = $request->validated();

        $stage->update($validated);

        return redirect()
            ->route('stages.index', $stage)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Stage $stage): RedirectResponse
    {
        $this->authorize('delete', $stage);

        $stage->delete();

        return redirect()
            ->route('stages.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
