<?php

namespace App\Http\Controllers\Api;

use App\Models\Lead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;

class LeadOrdersController extends Controller
{
    public function index(Request $request, Lead $lead): OrderCollection
    {
        $this->authorize('view', $lead);

        $search = $request->get('search', '');

        $orders = $lead
            ->orders()
            ->search($search)
            ->latest()
            ->paginate();

        return new OrderCollection($orders);
    }

    public function store(Request $request, Lead $lead): OrderResource
    {
        $this->authorize('create', Order::class);

        $validated = $request->validate([
            'customer_name' => ['required', 'max:255', 'string'],
            'customer_phone' => ['required', 'max:255', 'string'],
            'customer_address' => ['required', 'max:255', 'string'],
            'cost' => ['nullable', 'numeric'],
            'order_date' => ['required', 'date'],
            'delivery_date' => ['required', 'date'],
            'status_id' => ['required', 'exists:statuses,id'],
            'card_name' => ['required', 'max:255', 'json'],
        ]);

        $order = $lead->orders()->create($validated);

        return new OrderResource($order);
    }
}
