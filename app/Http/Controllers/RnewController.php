<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deal;
use App\Models\Card;
use Carbon\Carbon;
use App\Models\Lead;
use App\Models\DealCard;
use App\Models\Renew;

class RnewController extends Controller
{
    //  public function index(){
    //     $renews=Deal::where('status','Confirmation')->paginate(10);

    //     return view('app.renew.renew',compact( 'renews'));
    //  }


    public function index()
    {
        // Fetch deals with 'Confirmation' status and eager load the related DealCard
        $renews = Deal::where('status_id', '5')->where('status', 'Confirmation')->where('renew', '!=', 1)
            ->with('deal_cards') // Load related dealCards
            ->paginate(10);

        // Iterate through the deals to add the card cost
        foreach ($renews as $renew) {
            // Check if deal_cards exist
            if ($renew->deal_cards->isNotEmpty()) {
                // Initialize card_cost
                $renew->card_cost = 0; // Set default cost to 0

                // Iterate through each deal_card to fetch the card cost
                foreach ($renew->deal_cards as $dealCard) {
                    // Fetch the card based on the name in dealCard
                    $card = Card::where('name', $dealCard->card_name)->first();

                    // If the card is found, add its cost to the total
                    if ($card) {
                        $renew->card_cost += $card->cost; // Accumulate the card cost
                    } else {
                        $renew->card_cost += 0; // If card not found, add 0
                    }
                }
            } else {
                $renew->card_cost = 'No deal card';
            }
        }

        // Debugging output to inspect the $renews data

        $cards = Card::all();

        return view('app.renew.renew', compact('cards', 'renews'));
    }



    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'lead_id' => 'required',
            'card_name' => 'required',
            'customer_name.*' => 'required',
            'customer_phone.*' => 'required',
            'address' => 'required',
            'date_of_receipt' => 'required',
            'cost' => 'required',
            'defaultname' => 'required',
            'defaultphone' => 'required',
            'time' => 'required',

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


        $lead = Lead::where('id', $deal->lead->id)->first();
        $lead->update([
            'stage_id' => 7
        ]);

        $deal->users()->attach(auth()->id());

        $deal = Deal::where('id', $request->dealRenew)->first();
        if ($deal) {
            $deal->renew = 1; // Set the statues column to 1
            $deal->save();
        }
        $yearsToAdd = 1;
        $renew = new Renew(); // Assuming the model is named Renew
        $renew->price = $request->finalPrice;
        $renew->renew_time = Carbon::parse($deal->created_at)->addYears($yearsToAdd);
        $renew->deal_id = $deal->id;
        $renew->lead_id = $request->lead_id;
        $renew->deal_renew_id = $request->dealRenew;

        $renew->save();
        
        return redirect()->route('renew.index')->with('success', 'Renewal created successfully!');
    }
}
