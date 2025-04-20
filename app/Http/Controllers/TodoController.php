<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Support\Facades\DB;
use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $deliveryDateFrom = $request->get('delivery_date_from', '');
        $deliveryDateTo = $request->get('delivery_date_to', '');
        // Start with the query builder for leads
        
        $query = Lead::query();

        $childs = Auth::user()->childs()->with('childs')->get();
        $childIds = $childs->pluck('id')->toArray();

        // Get grandchildren IDs
        $grandchildIds = $childs->flatMap(function ($child) {
            return $child->childs->pluck('id');
        })->toArray();

        // Combine children and grandchildren IDs
        $checked = array_merge($childIds, $grandchildIds);

        if (!Auth::user()->hasRole('Super Admin')) {
            // Check if the user has children
            if (!empty($childIds)) {
                // If they have children, check if any child has children
                $childHasChildren = $childs->contains(function ($child) {
                    return $child->childs->isNotEmpty();
                });

                // If no children for any child, use only direct children
                if (!$childHasChildren) {
                    $checked = $childIds; // Use only the children's IDs
                }
            } else {
                // If the user has no children, include their own ID to show their leads
                $checked = [auth()->user()->id];
            }

            if (!Auth::user()->hasRole('Viewer Admin')) {
                // Fetch leads based on the determined IDs
                $query->whereHas('users', function ($query) use ($checked) {
                    $query->whereIn('users.id', $checked); // Use the IDs here
                });
            }
        }

        // Execute the query to get the leads
        $leads = $query
            ->whereNotNull('follow_date')
            ->paginate(5);

        return view('app.todo.index', compact('leads', 'deliveryDateFrom', 'deliveryDateTo'));
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
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        //
    }
}
