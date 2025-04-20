<?php

namespace App\Http\Controllers\Api;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\CardResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\CardCollection;
use App\Http\Requests\CardStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CardUpdateRequest;

class CardController extends Controller
{
    public function index(Request $request): CardCollection
    {
        $this->authorize('view-any', Card::class);

        $search = $request->get('search', '');

        $cards = Card::search($search)
            ->latest()
            ->paginate();

        return new CardCollection($cards);
    }

    public function store(CardStoreRequest $request): CardResource
    {
        $this->authorize('create', Card::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $card = Card::create($validated);

        return new CardResource($card);
    }

    public function show(Request $request, Card $card): CardResource
    {
        $this->authorize('view', $card);

        return new CardResource($card);
    }

    public function update(CardUpdateRequest $request, Card $card): CardResource
    {
        $this->authorize('update', $card);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($card->image) {
                Storage::delete($card->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $card->update($validated);

        return new CardResource($card);
    }

    public function destroy(Request $request, Card $card): Response
    {
        $this->authorize('delete', $card);

        if ($card->image) {
            Storage::delete($card->image);
        }

        $card->delete();

        return response()->noContent();
    }
}
