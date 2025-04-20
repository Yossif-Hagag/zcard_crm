<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StatusStoreRequest;
use App\Http\Requests\StatusUpdateRequest;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Status::class);

        $search = $request->get('search', '');

        $statuses = Status::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.statuses.index', compact('statuses', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Status::class);

        return view('app.statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StatusStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Status::class);

        $validated = $request->validated();

        $status = Status::create($validated);

        return redirect()
            ->route('statuses.edit', $status)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Status $status): View
    {
        $this->authorize('view', $status);

        return view('app.statuses.show', compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Status $status): View
    {
        $this->authorize('update', $status);

        return view('app.statuses.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        StatusUpdateRequest $request,
        Status $status
    ): RedirectResponse {
        $this->authorize('update', $status);

        $validated = $request->validated();

        $status->update($validated);

        return redirect()
            ->route('statuses.edit', $status)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Status $status): RedirectResponse
    {
        $this->authorize('delete', $status);

        $status->delete();

        return redirect()
            ->route('statuses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
