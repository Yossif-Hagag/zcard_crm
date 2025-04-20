<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\PrintCard;
use App\Models\Printing;
use App\Models\Shipping;
use App\Models\Lead;
use App\Models\ShippingCard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Exports\PrintingExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class PrintingController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('view-any', Printing::class);

        $x = 1;
        $search = $request->get('search', '');
        $createDateFrom = $request->get('create_date_from', '');
        $createDateTo = $request->get('create_date_to', '');
        $deliveryDateFrom = $request->get('delivery_date_from', '');
        $deliveryDateTo = $request->get('delivery_date_to', '');

        $printings = Printing::with('print_cards', 'lead')
            ->when(
                $search,
                fn(Builder $builder) => $builder->search($search)
            )
            ->where('status_id', NULL) //to get all without that going to shipping
            ->when($createDateFrom, function ($query) use ($createDateFrom) {
                return $query->whereDate('created_at', '>=', $createDateFrom);
            })
            ->when($createDateTo, function ($query) use ($createDateTo) {
                return $query->whereDate('created_at', '<=', $createDateTo);
            })
            ->when($deliveryDateFrom, function ($query) use ($deliveryDateFrom) {
                return $query->whereDate('delivery_date', '>=', $deliveryDateFrom);
            })
            ->when($deliveryDateTo, function ($query) use ($deliveryDateTo) {
                return $query->whereDate('delivery_date', '<=', $deliveryDateTo);
            })
            ->latest()
            ->paginate(7)
            ->withQueryString();

        return view('app.printings.index', compact('printings', 'search', 'createDateFrom', 'createDateTo', 'deliveryDateFrom', 'deliveryDateTo', 'x'));
    }

    public function to_print(PrintCard $print)
    {

        DB::transaction(function () use ($print) {
            // Update print status
            $print->print_status = "printing";
            $print->save(); // Save the model, no need to call update() explicitly

            // Find the associated printing and lead
            $deal = Deal::findOrFail($print->deal_id);

            // Update lead status
            $deal->update(['status_id' => 3]);
        });

        // Redirect back to the previous page
        return back();
    }
    public function to_sent(PrintCard $print)
    {
        $print->send_status = "sent";
        $print->update();
        return back();
    }

    public function to_confirm(Request $request, Printing $print, PrintCard $print_card)
    {
        $request->validate([
            'cancelOrDone' => 'required|in:done,cancel',
            'reason' => 'nullable|max:1000',
        ]);
        $print_card->update([
            'confirm_status' => $request->cancelOrDone,
            'confirm_reason' => $request->reason,
        ]);

        //if "printing" all cards done change status to go shipping
        if ($request->cancelOrDone == "done") {
            $countCardsForPrint = $print->print_cards->count();
            $countDoneStatusForPrint = $print->print_cards->filter(function ($print_card) {
                return $print_card->confirm_status == "done";
            })->count();

            // Find the associated printing and lead
            $deal = Deal::findOrFail($print_card->deal_id);

            // Update lead status
            $deal->update(['status_id' => 4]);


            if ($countCardsForPrint == $countDoneStatusForPrint) {
                $print->update(['status_id' => "1"]);

                // Create the shipping
                $shipping = Shipping::create([
                    'lead_id' => $print->lead_id,
                    'deal_id' => $deal->id,
                    'delivery_date' => $print->delivery_date,
                    'cost' => $print->cost,
                    'customer_address' => $print->customer_address,
                    'defaultname' => $print->defaultname,
                    'defaultphone' => $print->defaultphone,
                    'time' => $print->time,
                ]);

                // Create the print cards
                $printCards = PrintCard::where('print_id', $print->id)->get();
                foreach ($printCards as $printCard) {
                    ShippingCard::create([
                        'shipping_id' => $shipping->id,
                        'customer_name' => $printCard->customer_name,
                        'customer_phone' => $printCard->customer_phone,
                        'card_name' => $printCard->card_name,
                        'card_code' => $printCard->card_code,
                    ]);
                }
            }
        }

        return back();
    }

    public function update_code(Request $request, PrintCard $print)
    {
        $request->validate([
            'card_code' => [
                'nullable',
                'string',
                'min:8',
                'max:8',
                Rule::unique('print_cards')->ignore($print->id),
            ],
        ], [
            'card_code.string' => 'The Card Code must be a string',
            'card_code.min' => 'The Card Code must be exactly 8 characters',
            'card_code.max' => 'The Card Code must be exactly 8 characters',
            'card_code.unique' => 'The Card Code has already been taken',
        ]);
        $print->update(['card_code' => $request->card_code,]);
        return back();
    }
    public function returncancel(PrintCard $printcard)
    {
        $printcard->update(['confirm_status' => null, 'confirm_reason' => null]);
        return back();
    }

    public function export()
    {
        return Excel::download(new PrintingExport, 'leads.xlsx');
    }
}
