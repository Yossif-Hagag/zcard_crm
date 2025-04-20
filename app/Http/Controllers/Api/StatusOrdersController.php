<?php

namespace App\Http\Controllers\Api;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;

class StatusOrdersController extends Controller
{
    public function index(Request $request, Status $status): OrderCollection
    {
        $this->authorize('view', $status);

        $search = $request->get('search', '');

        $orders = $status
            ->orders()
            ->search($search)
            ->latest()
            ->paginate();

        return new OrderCollection($orders);
    }

    public function store(Request $request, Status $status): OrderResource
    {
        $this->authorize('create', Order::class);

        $validated = $request->validate([
            'customer_name' => ['required', 'max:255', 'string'],
            'customer_phone' => ['required', 'max:255', 'string'],
            'customer_address' => ['required', 'max:255', 'string'],
            'cost' => ['nullable', 'numeric'],
            'order_date' => ['required', 'date'],
            'delivery_date' => ['required', 'date'],
            'card_name' => ['required', 'max:255', 'json'],
            'lead_id' => ['required', 'exists:leads,id'],
        ]);

        $order = $status->orders()->create($validated);

        return new OrderResource($order);
    }
}
