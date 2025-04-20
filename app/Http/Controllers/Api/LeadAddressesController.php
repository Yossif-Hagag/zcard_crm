<?php
namespace App\Http\Controllers\Api;

use App\Models\Lead;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressCollection;

class LeadAddressesController extends Controller
{
    public function index(Request $request, Lead $lead): AddressCollection
    {
        $this->authorize('view', $lead);

        $search = $request->get('search', '');

        $addresses = $lead
            ->addresses()
            ->search($search)
            ->latest()
            ->paginate();

        return new AddressCollection($addresses);
    }

    public function store(
        Request $request,
        Lead $lead,
        Address $address
    ): Response {
        $this->authorize('update', $lead);

        $lead->addresses()->syncWithoutDetaching([$address->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Lead $lead,
        Address $address
    ): Response {
        $this->authorize('update', $lead);

        $lead->addresses()->detach($address);

        return response()->noContent();
    }
}
