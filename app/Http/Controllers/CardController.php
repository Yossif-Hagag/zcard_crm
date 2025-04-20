<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CardStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CardUpdateRequest;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Card::class);

        $search = $request->get('search', '');

        $cards = Card::query()
        ->when($search, function ($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(5)
        ->withQueryString();

        return view('app.cards.index', compact('cards', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Card::class);

        return view('app.cards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CardStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Card::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $card = Card::create($validated);

        return redirect()
            ->route('cards.edit', $card)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Card $card): View
    {
        $this->authorize('view', $card);

        return view('app.cards.show', compact('card'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Card $card): View
    {
        $this->authorize('update', $card);
    
        $search = $request->get('search', '');

        $cards = Card::query()
        ->when($search, function ($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(5)
        ->withQueryString();

        // Return a view for editing the card, passing the card data to the view
        return view('app.cards.edit', compact('card','cards'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        CardUpdateRequest $request,
        Card $card
    ): RedirectResponse {
        $this->authorize('update', $card);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($card->image) {
                Storage::delete($card->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $card->update($validated);

        return redirect()
            ->route('cards.edit', $card)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Card $card): RedirectResponse
    {
        $this->authorize('delete', $card);

        if ($card->image) {
            Storage::delete($card->image);
        }

        $card->delete();

        return redirect()
            ->route('cards.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
