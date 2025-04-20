<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class OrderUsersController extends Controller
{
    public function index(Request $request, Order $order): UserCollection
    {
        $this->authorize('view', $order);

        $search = $request->get('search', '');

        $users = $order
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    public function store(Request $request, Order $order, User $user): Response
    {
        $this->authorize('update', $order);

        $order->users()->syncWithoutDetaching([$user->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Order $order,
        User $user
    ): Response {
        $this->authorize('update', $order);

        $order->users()->detach($user);

        return response()->noContent();
    }
}
