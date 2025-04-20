<?php
namespace App\Http\Controllers\Api;

use App\Models\Lead;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeadCollection;

class AddressLeadsController extends Controller
{
    public function index(Request $request, Address $address): LeadCollection
    {
        $this->authorize('view', $address);

        $search = $request->get('search', '');

        $leads = $address
            ->leads()
            ->search($search)
            ->latest()
            ->paginate();

        return new LeadCollection($leads);
    }

    public function store(
        Request $request,
        Address $address,
        Lead $lead
    ): Response {
        $this->authorize('update', $address);

        $address->leads()->syncWithoutDetaching([$lead->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Address $address,
        Lead $lead
    ): Response {
        $this->authorize('update', $address);

        $address->leads()->detach($lead);

        return response()->noContent();
    }
}
