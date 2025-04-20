<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Massenger;
use Illuminate\Http\Request;

class MassengerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users= DB::table('users')->get();
        return view('app.chat.index' ,['users'=>$users]);
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
    public function show(Massenger $massenger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Massenger $massenger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Massenger $massenger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Massenger $massenger)
    {
        //
    }
}
