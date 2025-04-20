<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressCollection;

class UserAddressesController extends Controller
{
    public function index(Request $request, User $user): AddressCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $addresses = $user
            ->addresses()
            ->search($search)
            ->latest()
            ->paginate();

        return new AddressCollection($addresses);
    }

    public function store(
        Request $request,
        User $user,
        Address $address
    ): Response {
        $this->authorize('update', $user);

        $user->addresses()->syncWithoutDetaching([$address->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        User $user,
        Address $address
    ): Response {
        $this->authorize('update', $user);

        $user->addresses()->detach($address);

        return response()->noContent();
    }
}
