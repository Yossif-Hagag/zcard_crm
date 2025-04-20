<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Deal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

class AccountingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $users = DB::table('users')->get();

        return view('app.accounting.index', [
            'users' => $users

        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Accounting $accounting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Accounting $accounting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Accounting $accounting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accounting $accounting)
    {
        //
    }
    public function income()
    {
        if (Auth::user()->hasRole('Accounting')) {
            $incomes = Deal::where('status_id', '5')->get();
        } else {
            $incomes = collect(); // Return an empty collection if the user does not have the role
        }
        
        return view('app.accounting.income.index', compact('incomes'));
        
    }
}
