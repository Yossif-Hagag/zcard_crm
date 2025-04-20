<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class AddressUsersController extends Controller
{
    public function index(Request $request, Address $address): UserCollection
    {
        $this->authorize('view', $address);

        $search = $request->get('search', '');

        $users = $address
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    public function store(
        Request $request,
        Address $address,
        User $user
    ): Response {
        $this->authorize('update', $address);

        $address->users()->syncWithoutDetaching([$user->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Address $address,
        User $user
    ): Response {
        $this->authorize('update', $address);

        $address->users()->detach($user);

        return response()->noContent();
    }
}
