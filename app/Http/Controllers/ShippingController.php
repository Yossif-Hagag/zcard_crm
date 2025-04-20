<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\RejectShippingReasonShipping;
use App\Models\Shipping;
use App\Models\User;
use App\Models\ShippingDelay;
use App\Models\Lead;
use App\Models\RejectShippingReasons;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ShippingController extends Controller
{


    public function index(Request $request)
    {
        $this->authorize('view-any', Shipping::class);

        $x = 1;
        $customer_name = $request->get('customer_name', '');
        $customer_phone = $request->get('customer_phone', '');
        $location = $request->get('location', '');
        $price = $request->get('price', '');
        $delivery_status = $request->get('delivery_status', '');
        $attempts = $request->get('attempts', '');
        $deliveryDateFrom = $request->get('delivery_date_from', '');
        $deliveryDateTo = $request->get('delivery_date_to', '');
        $delivery_boy = $request->get('delivery_boy', '');
        $salesInp = $request->get('sales', '');

        $search = $request->get('search', '');
        $search_select = $request->get('search_select', '');
        $item_name = $request->get('item_name', 'all');
        $delivryBoys = User::whereHas('roles', function ($query) {
            $query->where('name', 'Delivery Boy')->orwhere('name', 'Shipping Company');
        })->get();
        $user = auth()->user();

        $sales = $user->when($user->hasRole('Team Leader'), function ($query) use ($user) {
            return $user->childs()->whereHas('roles', function ($query) {
                $query->where('name', 'Sales');
            });
        }, function ($query) {
            return User::whereHas('roles', function ($query) {
                $query->where('name', 'Sales');
            });
        })->get();

        $reject_resons = RejectShippingReasons::get();
        $user = Auth::user();
        $query = Shipping::with('shipping_cards', 'lead', 'rejectShippingReasons', 'users');

        
        $statusFilters = [];
        if ($user->hasRole("Delivery Boy") || $user->hasRole("Shipping Company")) {
            $statusFilters = [
                'all' => 'all',
                'new' => null,
                'in-progress' => null,
                'on-the-way' => null,
                'waiting-for-follow-up' => 'waiting-for-follow-up',
                'completed' => 'completed',
                'unsuccessful' => null,
                'returns-rejected' => null,
            ];
        } elseif ($user->hasRole("Super Admin") || $user->hasRole("Team Leader") || $user->hasRole("Shipping Operation")) {
            $statusFilters = [
                'all' => 'all',
                'new' => 'new',
                'in-progress' => 'in-progress',
                'on-the-way' => 'on-the-way',
                'waiting-for-follow-up' => 'waiting-for-follow-up',
                'completed' => 'completed',
                'unsuccessful' => 'unsuccessful',
                'returns-rejected' => 'returns-rejected',
            ];
        }

        // Apply common search logic
        $query->when(
            $search,
            fn(Builder $builder) => $builder->searchSelected($item_name, $user, $statusFilters, $search, $search_select)
        );


        $query->when($item_name, function (Builder $query) use ($item_name, $statusFilters, $user) {
           
    
            if ($user->hasRole("Delivery Boy") || $user->hasRole("Shipping Company")) {
                if (array_key_exists($item_name, $statusFilters)) {
                    // Common query to filter by shipping status and user ID
                    $query->whereHas('users', function ($query) {
                        $query->where('users.id', auth()->user()->id);
                    });
      
                    if ($item_name === 'all') {
                        $query->whereIn('shipping_status', ['waiting-for-follow-up', 'completed']);
                 
                    } else {
                      if (array_key_exists($item_name, $statusFilters)) {
                        $query->where('shipping_status', $statusFilters[$item_name]);
                    }
                       
                    }     
                }
            }
          
            if ($user->hasRole("Super Admin") || $user->hasRole("Team Leader") || $user->hasRole("Shipping Operation")) {
                if ($item_name === 'all') {
                    $query->whereIn('shipping_status', ['new', 'in-progress', 'on-the-way', 'waiting-for-follow-up', 'completed', 'unsuccessful', 'returns-rejected']);
                } else {
                    if (array_key_exists($item_name, $statusFilters)) {
                        $query->where('shipping_status', $statusFilters[$item_name]);
                    }
                }
            }
        });

       
        $query->when($customer_name, function ($query) use ($customer_name) {
            return $query->where('defaultname', 'like', '%' . $customer_name . '%');
        });
        $query->when($customer_phone, function ($query) use ($customer_phone) {
            return $query->where('defaultphone', 'like', '%' . $customer_phone . '%');
        });
        $query->when($location, function ($query) use ($location) {
            return $query->where('customer_address', 'like', '%' . $location . '%');
        });
        $query->when($price, function ($query) use ($price) {
            return $query->where('cost', 'like', '%' . $price . '%');
        });
        $query->when($delivery_status, function ($query) use ($delivery_status) {
            return $query->where('delivery_status', $delivery_status);
        });
        $query->when($attempts, function ($query) use ($attempts) {
            return $query->where('attempts', $attempts);
        });
        $query->when($deliveryDateFrom, function ($query) use ($deliveryDateFrom) {
            return $query->whereDate('delivery_date', '>=', $deliveryDateFrom);
        });
        $query->when($deliveryDateTo, function ($query) use ($deliveryDateTo) {
            return $query->whereDate('delivery_date', '<=', $deliveryDateTo);
        });
        $query->when($delivery_boy, function ($query) use ($delivery_boy) {
            return $query->whereHas('users', function ($query) use ($delivery_boy) {
                return $query->where('users.id', $delivery_boy);
            });
        });
        $query->when($salesInp, function ($query) use ($salesInp) {
            return $query->whereHas('lead', function ($query) use ($salesInp) {
                return $query->whereHas('users', function ($query) use ($salesInp) {
                    return $query->where('users.id', $salesInp);
                });
            });
        });

        if (!$user->hasRole('Shipping Operation')) {
        $user = Auth::user();

        $childs = $user->childs()->with('childs')->get();
        $childIds = $childs->pluck('id')->toArray();

        $grandchildIds = $childs->flatMap(function ($child) {
            return $child->childs->pluck('id');
        })->toArray();

        $checked = array_merge($childIds, $grandchildIds);

        if (!$user->hasRole('Super Admin')) {
            if ($childIds) {
                $childHasChildren = $childs->contains(function ($child) {
                    return $child->childs->isNotEmpty();
                });

                if (!$childHasChildren) {
                    $checked = $childIds;
                }
            } else {
                $checked = [$user->id];
            }

            if (!$user->hasRole('Viewer Admin') && !$user->hasRole('Delivery Boy')) {
                $query->when($checked, function ($query) use ($checked) {
                    $query->whereHas('lead', function ($query) use ($checked) {
                        $query->whereHas('users', function ($query) use ($checked) {
                            $query->whereIn('users.id', $checked);
                        });
                    });
                });
            }
        }

        }


        // Execute the query
        $shippings = $query
            ->latest()
            ->paginate(7)
            ->withQueryString();


        return view('app.shipping.index', compact('shippings', 'sales', 'search', 'search_select', 'item_name', 'delivryBoys', 'x', 'reject_resons', 'deliveryDateFrom', 'deliveryDateTo'));
    }
    public function save_delvery_boy(Request $request, Shipping $shipping)
    {
        // sync shipping with User Delivery Boy
        if ($request->delviery_boys != null) {
            $shipping->users()->attach($request->delviery_boys);
            $user = User::with('roles')->find($request->delviery_boys);
            $delivery_stat = ($user->roles->first()->name == 'Shipping Company') ? 'Shipping Company' : 'Delivery Representatives';
            $shipping->update(['shipping_status' => 'in-progress', 'delivery_status' => $delivery_stat]);
        }
        return back();
    }
    public function update_delvery_boy(Request $request, Shipping $shipping)
    {
        // sync shipping with User Delivery Boy
        if ($request->delviery_boys != null) {
            $shipping->users()->detach();
            $shipping->users()->attach($request->delviery_boys);
            $user = User::with('roles')->find($request->delviery_boys);
            $delivery_stat = ($user->roles->first()->name == 'Shipping Company') ? 'Shipping Company' : 'Delivery Representatives';
            $shipping->shipping_status = 'in-progress';
            $shipping->delivery_status = $delivery_stat;
            $shipping->attempts++;
            $shipping->update();
        }
        return back();
    }
    public function change_status(Request $request, Shipping $shipping)
    {
        switch ($request->btnStat) {
            case 'in-progress':
                $shipping->shipping_status = 'on-the-way';
                $shipping->update();
                break;
            case 'on-the-way':
                $shipping->shipping_status = 'waiting-for-follow-up';
                $shipping->update();
                break;
            case 'completed':
                $shipping->shipping_status = 'completed';
                $shipping->update();

                //update status for lead
                $deal = Deal::findOrFail($shipping->deal_id);
                $deal->update(['status_id' => 5]);
                break;
            case 'unsuccessful-follw':
                $shipping->shipping_status = 'unsuccessful';
                $shipping->update();
                break;
            case 'returns-rejected':
                $shipping->shipping_status = 'returns-rejected';
                $shipping->update();
                break;
            case 'unsuccessful':
                $shipping->shipping_status = 'in-progress';
                $shipping->attempts++;
                $shipping->update();
                break;
            default:
                break;
        }

        return back();
    }
    public function reason_reject(Request $request, Shipping $shipping)
    {
        // Validate the incoming request
        $request->validate([
            'reason_id' => 'required|exists:reject_shipping_reasons,id',
            'other' => 'nullable|string',
        ]);

        $reasonId = $request->input('reason_id');
        $other = $request->input('other');

        // Sync the pivot table
        $shipping->rejectShippingReasons()->sync([$reasonId]);

        // Update the 'other' field in the pivot table
        $rejectShippingReasonShipping = RejectShippingReasonShipping::where('shipping_id', $shipping->id)
            ->where('reject_shipping_reason_id', $reasonId)
            ->first();

        if ($rejectShippingReasonShipping) {
            $rejectShippingReasonShipping->other = $other;
            $rejectShippingReasonShipping->save();
        }

        return back();
    }





    public function Delay(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'deal_id' => 'required|exists:deals,id', // Make sure the deal_id exists in the deals table
            'delay_time' => 'required|date',
            'comment' => 'required|max:255',
        ]);

        // Retrieve the shipping record by its ID
        $shipping = Shipping::find($id); // It's safer to use find instead of where()->first()

        // Check if the shipping record exists
        if (!$shipping) {
            return redirect()->back()->with('error', 'Shipping record not found.');
        }

        // Retrieve the deal using the validated deal_id
        $deal = Deal::find($validatedData['deal_id']);

        // Check if the deal exists
        if (!$deal) {
            return redirect()->back()->with('error', 'Deal not found.');
        }

        // Update the shipping record with the new delay time
        $shipping->update(['delivery_date' => $validatedData['delay_time']]);

        // Create the DealDelay record with status set to 'on receipt'
        ShippingDelay::create([
            'deal_id' => $deal->id, // Use the validated deal_id
            'shipping_id' =>$id, // Use the validated deal_id
            'reason' => $validatedData['comment'],
            'date' => $validatedData['delay_time'],
            'status' => 'on receipt', // This can be customized based on your logic
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Shipping delay recorded successfully.');
    }

}
