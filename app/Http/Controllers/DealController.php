<?php


namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Lead;
use App\Models\Status;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\DealStoreRequest;
use App\Http\Requests\DealUpdateRequest;
use App\Models\Card;
use App\Models\Address;
use App\Models\Contract;
use App\Models\Source;
use App\Models\DealCard;
use App\Models\Shipping;
use App\Models\DealDelay;
use App\Models\PrintCard;
use App\Models\Printing;
use App\Models\Stage;
use App\Models\User;
use App\Jobs\DeleteDealJob;

class DealController extends Controller
{


    public function index(Request $request): View
    {
        $this->authorize('view-any', Deal::class);

        $search = $request->get('search', '');
        $dealDateFrom = $request->get('deal_date_from', '');
        $dealDateTo = $request->get('deal_date_to', '');
        $receiptDateFrom = $request->get('receipt_date_from', '');
        $receiptDateTo = $request->get('receipt_date_to', '');
        $stat_id = Status::where('name', 'Confirmation')->first();

        $deals = Deal::with(['deal_cards', 'status', 'lead']) // Eager load the lead relationship
            ->where('status_id', 1)
            ->when($search, function ($query) use ($search) {
                return $query->search($search);
            })
            ->when($dealDateFrom, function ($query) use ($dealDateFrom) {
                return $query->whereDate('deal_date', '>=', $dealDateFrom);
            })
            ->when($dealDateTo, function ($query) use ($dealDateTo) {
                return $query->whereDate('deal_date', '<=', $dealDateTo);
            })
            ->when($receiptDateFrom, function ($query) use ($receiptDateFrom) {
                return $query->whereDate('delivery_date', '>=', $receiptDateFrom);
            })
            ->when($receiptDateTo, function ($query) use ($receiptDateTo) {
                return $query->whereDate('delivery_date', '<=', $receiptDateTo);
            })
            ->latest()
            ->paginate(7)
            ->withQueryString();

        $statuses = Status::get();

        $dealsTotal = Deal::get()->count();
        $dealsConfirmed = Deal::where('status_id', '>', 1)->count();
        $dealsPending = Deal::where('status_id', 1)->count();
        $cards = Card::get();
        $leads = Lead::get();

        // Retrieve other necessary data for the view
        $stages = Stage::pluck('name', 'id');
        $stagess = Stage::get();
        $sources  = Source::pluck('name', 'id');
        $contracts = Contract::pluck('name', 'id');

        return view('app.deals.index', compact('leads', 'stages', 'contracts', 'deals', 'cards', 'search', 'statuses', 'dealsTotal', 'dealsPending', 'dealsConfirmed', 'receiptDateTo', 'receiptDateFrom', 'dealDateTo', 'dealDateFrom'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Deal::class);

        $leads = Lead::pluck('name', 'id');
        $statuses = Status::pluck('name', 'id');

        return view('app.deals.create', compact('leads', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request, Lead $lead)
    // {
    //     if ($lead->load('users')->users()->count() >  0) {
    //         // Validate the input data
    //         $validatedData = $request->validate([
    //             'lead_id' => 'required|exists:leads,id',
    //             'card_name' => 'required|string',
    //             'customer_name.*' => 'required|string',
    //             'customer_phone.*' => 'required|string',
    //             'address' => 'required|string',
    //             'date_of_receipt' => 'required|date',
    //             'cost' => 'numeric',
    //             'defaultname' => 'required|string',
    //             'defaultphone' => 'required',
    //             'time' => 'required|date_format:H:i',

    //         ]);

    //         $selectCard = Card::where('id', $validatedData['card_name'])->first();
    //         // Create the deal
    //         $deal = Deal::create([
    //             'status_id' => 1,
    //             'lead_id' => $validatedData['lead_id'],
    //             'deal_date' => now(),
    //             'delivery_date' => $validatedData['date_of_receipt'],
    //             // 'cost' => $request->finalPrice,
    //              'cost' => 0,
    //             'customer_address' => $validatedData['address'],
    //             'defaultname' => $validatedData['defaultname'],
    //             'defaultphone' => $validatedData['defaultphone'],
    //             'time' => $validatedData['time'],
    //         ]);

    //         foreach ($validatedData['customer_name'] as $index => $customerName) {
    //             DealCard::create([
    //                 'deal_id' => $deal->id,
    //                 'customer_name' => $customerName,
    //                 'customer_phone' => $validatedData['customer_phone'][$index],
    //                 'card_name' => $selectCard->name,
    //             ]);
    //         }

    //         $deal->users()->attach(auth()->id());
    //         return back()->with('success', 'Deal created successfully');
    //     } else {
    //         return back()->with('error', 'No Sale of Lead Exist !');
    //     }
    // }


    public function store(Request $request, Lead $lead)
    {
     
        if ($lead->load('users')->users()->count() >  0) {
            // Validate the input data
            $validatedData = $request->validate([
                'lead_id' => 'required|exists:leads,id',
                'card_name' => 'required|string',
                'customer_name.*' => 'required|string',
                'customer_phone.*' => 'required|string',
                'address' => 'required|string',
                'date_of_receipt' => 'required|date',
                'cost' => 'required|numeric',
                'defaultname' => 'required|string',
                'defaultphone' => 'required',
                'time' => 'required|date_format:H:i',

            ]);
            $selectCard = Card::where('id', $validatedData['card_name'])->first();
            // Create the deal
            $deal = Deal::create([
                'status_id' => 1,
                'lead_id' => $validatedData['lead_id'],
                'deal_date' => now(),
                'delivery_date' => $validatedData['date_of_receipt'],
                'cost' => $request->finalPrice,
                'customer_address' => $validatedData['address'],
                'defaultname' => $validatedData['defaultname'],
                'defaultphone' => $validatedData['defaultphone'],
                'time' => $validatedData['time'],
            ]);
            foreach ($validatedData['customer_name'] as $index => $customerName) {
                DealCard::create([
                    'deal_id' => $deal->id,
                    'customer_name' => $customerName,
                    'customer_phone' => $validatedData['customer_phone'][$index],
                    'card_name' => $selectCard->name,
                ]);
            }

            $deal->users()->attach(auth()->id());
            return back()->with('success', 'Deal created successfully');
        }else{
            return back()->with('error', 'No Sale of Lead Exist !');
        }

    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request, Deal $deal): View
    {
        $this->authorize('view', $deal);

        return view('app.deals.show', compact('deal'));
    }


    public function edit(Request $request, Deal $deal): View
    {
        $this->authorize('update', $deal);

        $leads = Lead::pluck('name', 'id');
        $statuses = Status::pluck('name', 'id');
        $cards = Card::pluck('name', 'id');

        return view('app.deals.edit', compact('deal', 'cards', 'leads', 'statuses'));
    }


    // public function update(
    //     DealUpdateRequest $request,
    //     Deal $deal
    // ): RedirectResponse {
    //     $this->authorize('update', $deal);

    //     $validated = $request->validated();
    //     $validated['card_name'] = json_decode($validated['card_name'], true);

    //     $deal->update($validated);

    //     return redirect()
    //         ->route('deals.edit', $deal)
    //         ->withSuccess(__('crud.common.saved'));
    // }



    public function update(Request $request, Deal $deal): RedirectResponse
    {

        // Authorize the user to update the deal
        $this->authorize('update', $deal);
        // Validate the input data
        $validatedData = $request->validate([
            'lead_id' => 'exists:leads,id',
            'card_name' => 'nullable|exists:cards,id',

            'customer_name.*' => 'nullable|string',

            'customer_phone.*' => 'nullable|string',
            'address' => 'nullable|string',
            'date_of_receipt' => 'nullable|date',
            'cost' => 'nullable|numeric',
            'defaultname' => 'nullable|string',
            'defaultphone' => 'nullable|string',
            'time' => 'nullable|date_format:H:i',
        ]);

        $address = Address::where('id', $validatedData['address'])->first();
        // Fetch the card information based on the card_name if provided
        $selectCard = isset($validatedData['card_name']) ? Card::find($validatedData['card_name']) : null;

        // Update the deal with the validated data, excluding null values
        $deal->update(array_filter([
            'lead_id' => $validatedData['lead_id'] ?? $deal->lead_id,
            'deal_date' => now(),
            'delivery_date' => $validatedData['date_of_receipt'] ?? $deal->delivery_date,
            'cost' => $request->finalPrice ? $request->finalPrice : $deal->cost,
            'customer_address' => $address->state ?? $deal->customer_address,
            'defaultname' => $validatedData['defaultname'] ?? $deal->defaultname,
            'defaultphone' => $validatedData['defaultphone'] ?? $deal->defaultphone,
            'time' => $validatedData['time'] ?? $deal->time,
        ]));




        // Update or create DealCards
        $existingDealCards = $deal->deal_cards;

        foreach ($validatedData['customer_name'] ?? [] as $index => $customerName) {
            $customerPhone = $validatedData['customer_phone'][$index] ?? null;

            // Check if the DealCard exists (assuming you have an ID for the card; adjust if necessary)
            if (isset($existingDealCards[$index])) {
                // Update existing DealCard
                $existingDealCards[$index]->update([
                    'customer_name' => $customerName,
                    'customer_phone' => $customerPhone,
                    'card_name' => $selectCard ? $selectCard->name : $existingDealCards[$index]->card_name,
                ]);
            } else {
                // Create a new DealCard if it doesn't exist
                DealCard::create([
                    'deal_id' => $deal->id,
                    'customer_name' => $customerName,
                    'customer_phone' => $customerPhone,
                    'card_name' => $selectCard ? $selectCard->name : null,
                ]);
            }
        }

        return redirect()
            ->route('deals.index', $deal)
            ->withSuccess(__('crud.common.saved'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Deal $deal): RedirectResponse
    {
        $this->authorize('delete', $deal);

        $deal->delete();
        // Reload table data
        $deals = deal::latest()->paginate(5);
        return redirect()
            ->route('deals.index')
            ->withSuccess(__('crud.common.removed'))
            ->with('deals', $deals); // Pass updated deals data
    }
    public function restore(Request $request, $id): RedirectResponse
    {
        $this->authorize('restore', Deal::class);

        $Deal = Deal::onlyTrashed()->findOrFail($id);
        $Deal->restore();

        return redirect()
            ->route('deals.archive')
            ->withSuccess(__('crud.common.restored'));
    }
    public function archive(Request $request): View
    {

        $this->authorize('view-any', Lead::class);

        $search = $request->get('search', '');

        $deals = deal::onlyTrashed()
            ->when($search, function ($query) use ($search) {
                return $query->search($search);
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();
        $stages = Stage::pluck('name', 'id');
        $contracts = Contract::pluck('name', 'id');
        $cards = Card::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view('app.deals.archive', compact('deals', 'search', 'stages', 'contracts', 'cards', 'users'));
    }
    public function forceDelete($id)
    {
        $deal = Deal::withTrashed()->findOrFail($id);

        $deal->forceDelete();

        return redirect()->route('deals.archive')->with('success', 'Deal permanently deleted.');
    }

    public function updateStatus(Request $request, $id)
    {

        $deal = Deal::findOrFail($id);


        if ($request->input('cancelOrDone') == 'done') {

            $deal->status = 'Confirmation';
            $deal->status_id = 2;
            $deal->save();


            $status = Status::findOrFail(2);
            if ($status->name == "Confirmation") {
                $lead = Lead::findOrFail($deal->lead_id);


                $lead->update(['status_id' => 2]);


                $print = Printing::create([
                    'lead_id' => $deal->lead_id,
                    'delivery_date' => $deal->delivery_date->format('Y-m-d'),
                    'cost' => $deal->cost,
                    'customer_address' => $deal->customer_address,
                    'defaultname' => $deal->defaultname,
                    'defaultphone' => $deal->defaultphone,
                    'time' => $deal->time,
                ]);

                $dealCards = DealCard::where('deal_id', $deal->id)->get();
                foreach ($dealCards as $dealCard) {
                    PrintCard::create([
                        'print_id' => $print->id,
                        'deal_id' => $deal->id,
                        'customer_name' => $dealCard->customer_name,
                        'customer_phone' => $dealCard->customer_phone,
                        'card_name' => $dealCard->card_name,
                    ]);
                }


                $print->users()->attach(auth()->id());
            }


            return redirect()->route('deals.index')->with('success', 'Deal confirmed and printed successfully.');
        }

        if ($request->input('cancelOrDone') == 'cancel') {

            $deal->status = 'canceled';
            $deal->comment = $request->input('comment');
            $deal->save();
            $deal->delete();

            return redirect()->route('deals.index')->with('success', 'Deal canceled with comment.');
        }
        if ($request->input('cancelOrDone') == 'not answered') {
            $deal->status = 'not answered';
            $deal->save();


            DeleteDealJob::dispatch($deal->id)->delay(now()->addDays(2));

            return redirect()->route('deals.index')->with('success', 'Deal Not Answered.');
        }

        return redirect()->route('deals.index')->with('error', 'No valid action performed.');
    }
}
