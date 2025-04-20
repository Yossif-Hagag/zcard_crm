<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Lead;
use App\Models\Printing;
use App\Models\Shipping;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //lead
        $newLeads = Lead::where('stage_id', 1)->count();
        $notAnsweredLeads = Lead::where('stage_id', 2)->count();
        $followUpLeads = Lead::where('stage_id', 6)->count();
        $coldLeads = Lead::where('stage_id', 3)->count();
        $notInterestedLeads = Lead::where('stage_id', 4)->count();
        $hotLeads = Lead::where('stage_id', 5)->count();

        //printing
        $allPrintings = Printing::get()->count();
        $donePrintings = Printing::whereHas('print_cards', function ($query) {
            $query->where('print_cards.confirm_status', 'done');
        })->count();
        $cancelPrintings = Printing::whereHas('print_cards', function ($query) {
            $query->where('print_cards.confirm_status', 'cancel');
        })->count();

        //users
        $total = User::count();
        $totalSales = User::whereHas('roles', function ($query) {
            $query->where('name', 'sales');
        })->count();
        $totalStafe = User::whereDoesntHave('roles', function ($query) {
            $query->whereIn('name', ['sales', 'superadmin']);
        })->count();
        $totalOrder = Deal::where('status_id', 5)
            ->whereBetween('delivery_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->count();

        //deal
        $Request = Deal::where('status_id', 1)->count();
        $Confirmation = Deal::where('status_id', 2)->count();
        $Print = Deal::where('status_id', 3)->count();
        $Shipping = Deal::where('status_id', 4)->count();
        $Reception = Deal::where('status_id', 5)->count();

        // Shipping
        $All = Shipping::count();

        $new = Shipping::where('shipping_status', 'new')->count();
        $newpersent = $All > 0 ? round(($new / $All) * 100, 2) : 0;

        $inprogress = Shipping::where('shipping_status', 'in-progress')->count();
        $inprogresspersent = $All > 0 ? round(($inprogress / $All) * 100, 2) : 0;

        $ontheway = Shipping::where('shipping_status', 'on-the-way')->count();
        $onthewaypersent = $All > 0 ? round(($ontheway / $All) * 100, 2) : 0;

        $waiting0forfollowup = Shipping::where('shipping_status', 'waiting-for-follow-up')->count();
        $waiting0forfollowuppersent = $All > 0 ? round(($waiting0forfollowup / $All) * 100, 2) : 0;

        $completed = Shipping::where('shipping_status', 'completed')->count();
        $completedpersent = $All > 0 ? round(($completed / $All) * 100, 2) : 0;

        $unsuccessful = Shipping::where('shipping_status', 'unsuccessful')->count();
        $unsuccessfulpersent = $All > 0 ? round(($unsuccessful / $All) * 100, 2) : 0;

        $returnsrejected = Shipping::where('shipping_status', 'returns-rejected')->count();
        $returnsrejectedpersent = $All > 0 ? round(($returnsrejected / $All) * 100, 2) : 0;


        if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole("Viewer Admin")) {
            return view(
                'home',
                compact(
                    'newLeads',
                    'notAnsweredLeads',
                    'followUpLeads',
                    'coldLeads',
                    'notInterestedLeads',
                    'hotLeads',
                    'total',
                    'totalSales',
                    'totalStafe',
                    'totalOrder',
                    'allPrintings',
                    'donePrintings',
                    'cancelPrintings',
                    'All',
                    'Print',
                    'Confirmation',
                    'Shipping',
                    'Reception',
                    'Request',
                    'newpersent',
                    'inprogresspersent',
                    'onthewaypersent',
                    'waiting0forfollowuppersent',
                    'completedpersent',
                    'unsuccessfulpersent',
                    'unsuccessfulpersent',
                    'returnsrejectedpersent'
                )
            );
        }
        // Redirect based on other roles
        if (Auth::user()->hasRole("Shipping Operation")) {
            return redirect()->route('shippings.index');
        }

        if (Auth::user()->hasRole("Printing")) {
            return redirect()->route('printings.index');
        }

        if (Auth::user()->hasRole("Confirmation Deal")) {
            return redirect()->route('deals.index');
        }

        if (Auth::user()->hasRole("Sales")) {
            return redirect()->route('leads.index');
        }
        if (Auth::user()->hasRole("Social Media Boy")) {
            return redirect()->route('leads.index');
        }
        if (Auth::user()->hasRole("Director")) {
            return redirect()->route('leads.index');
        }

        if (Auth::user()->hasRole("Team Leader")) {
            return redirect()->route('leads.index');
        }
        if (Auth::user()->hasRole("Delivery Boy")) {
            return redirect()->route('shippings.index');
        }
        if (Auth::user()->hasRole("Shipping Company")) {
            return redirect()->route('shippings.index');
        }


        Auth::logout();
        return  redirect()->route('home');
    }
}
