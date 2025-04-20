<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Card;
use App\Models\Stage;
use App\Models\Source;
use App\Models\User;
use App\Models\Deal;
use App\Models\Status;
use App\Models\Contract;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\LeadStoreRequest;
use App\Http\Requests\LeadUpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Exports\LeadsExport;
use App\Imports\LeadsImport;
use Dotenv\Exception\ValidationException;
use Maatwebsite\Excel\Facades\Excel;


class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Lead::class);

        // Retrieve filter inputs
        $name = $request->get('name', '');
        $phone = $request->get('phone', '');
        $stageId = $request->get('stage_id', '');
        $sourceId = $request->get('source_id', '');
        $followDateFrom = $request->get('follow_date_from', '');
        $followDateTo = $request->get('follow_date_to', '');
        $createDateFrom = $request->get('create_date_from', '');
        $createDateTo = $request->get('create_date_to', '');
        $contractId = $request->get('contract_id', '');
        $cardId = $request->get('card_id', '');
        $selectedUserId = $request->get('user_id', '');

        $leads = Lead::query()
            //->withTrashed() // Uncomment if you want to include trashed records
            ->with('deals')
            ->when($name, function ($query) use ($name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($phone, function ($query) use ($phone) {
                return $query->where('phone', 'like', '%' . $phone . '%');
            })
            ->when($stageId, function ($query) use ($stageId) {
                return $query->where('stage_id', $stageId);
            })
            ->when($sourceId, function ($query) use ($sourceId) {
                return $query->where('source_id', $sourceId);
            })
            ->when($followDateFrom, function ($query) use ($followDateFrom) {
                return $query->whereDate('follow_date', '>=', $followDateFrom);
            })
            ->when($followDateTo, function ($query) use ($followDateTo) {
                return $query->whereDate('follow_date', '<=', $followDateTo);
            })
            ->when($createDateFrom, function ($query) use ($createDateFrom) {
                return $query->whereDate('created_at', '>=', $createDateFrom);
            })
            ->when($createDateTo, function ($query) use ($createDateTo) {
                return $query->whereDate('created_at', '<=', $createDateTo);
            })
            ->when($contractId, function ($query) use ($contractId) {
                return $query->where('contract_id', $contractId);
            })
            ->when($cardId, function ($query) use ($cardId) {
                return $query->where('card_id', $cardId);
            });

            if ($selectedUserId === 'without') {
                $leads->doesntHave('users'); // Excludes records that have any associated users
            } elseif ($selectedUserId) {
                $leads->whereHas('users', function ($query) use ($selectedUserId) {
                    $query->where('users.id', $selectedUserId);
                });
            }
            $leads->latest();


        $childs = Auth::user()->childs()->with('childs')->get();
        $childIds = $childs->pluck('id')->toArray();

        // Get grandchildren IDs
        $grandchildIds = $childs->flatMap(function ($child) {
            return $child->childs->pluck('id');
        })->toArray();

        // Combine children and grandchildren IDs
        $checked = array_merge($childIds, $grandchildIds);

        if (!Auth::user()->hasRole('Super Admin') && !Auth::user()->hasRole('Confirmation Deal')) {
            // Check if the user has children
            if ($childIds) {
                // If they have children, check if any child has children
                $childHasChildren = $childs->contains(function ($child) {
                    return $child->childs->isNotEmpty();
                });

                // If no children for any child, use only direct children
                if (!$childHasChildren) {
                    $checked = $childIds; // Use only the children's IDs
                }
                $checked[] = auth()->user()->id;
            } else {
                // If the user has no children, include their own ID to show their leads
                $checked = [auth()->user()->id];
            }

            if (!Auth::user()->hasRole('Viewer Admin')) {
                // Fetch leads based on the determined IDs
                $leads->whereHas('users', function ($query) use ($checked) {
                    $query->whereIn('users.id', $checked); // Use the IDs here
                });
            }
        }


        // Execute the query
        $leads = $leads->paginate(100)->appends($request->query());

        // Retrieve other necessary data for the view
        $stages = Stage::pluck('name', 'id');
        $stagess = Stage::get();
        $sources  = Source::pluck('name', 'id');
        $contracts = Contract::pluck('name', 'id');
        $cards = Card::pluck('name', 'id');
        // $users = User::whereDoesntHave('roles', function ($query) {
        //     $query->where('name', 'Delivery Boy');
        // })->pluck('name', 'id');

        $childs = Auth::user()->childs()->with('childs')->get();
        $childIds = $childs->pluck('id')->toArray();

        // Get grandchildren IDs
        $grandchildIds = $childs->flatMap(function ($child) {
            return $child->childs->pluck('id');
        })->toArray();

        // Combine children and grandchildren IDs
        $checked = array_merge($childIds, $grandchildIds);

        // Check if the authenticated user is not a 'Super Admin'
        if (!Auth::user()->hasRole('Super Admin')&& !Auth::user()->hasRole('Confirmation Deal')) {
            // Check if the user has children
            if (!empty($childIds)) {
                // Check if any child has children
                $childHasChildren = $childs->contains(function ($child) {
                    return $child->childs->isNotEmpty();
                });

                // If no child has children, use only direct children
                if (!$childHasChildren) {
                    $checked = $childIds; // Use only the children's IDs
                }
                $checked[] = auth()->user()->id;
            } else {
                // If the user has no children, include their own ID
                $checked = [auth()->user()->id];
            }
        //     $userss = User::whereHas('roles', function ($query) {
        //         $query->where('name', 'Sales');
        //     })->whereIn('id', $checked)->get();
        // } else {
        //     $userss = User::whereHas('roles', function ($query) {
        //         $query->where('name', 'Sales');
        //     })->get();
        // }
        $userss = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Sales', 'Team Leader','Director']);
        })->whereIn('id', $checked)->get();
    } else {
        $userss = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Sales', 'Team Leader','Director']);
        })->get();
    }



        // Return the view with the data
        return view('app.leads.index', compact('leads', 'stages', 'contracts', 'cards', 'selectedUserId', 'sources', 'userss', 'stagess', 'createDateTo', 'createDateFrom', 'followDateTo', 'followDateFrom'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Lead::class);

        $stages = Stage::pluck('name', 'id');
        $contracts = Contract::pluck('name', 'id');
        $cards = Card::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.leads.create',
            compact('stages', 'contracts', 'cards', 'users')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeadStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Lead::class);

        $validated = $request->validated();

        $lead = Lead::create($validated);
        if (isset($validated['user_id'])) {
            $lead->users()->sync($validated['user_id']);
        }


        return redirect()
            ->route('leads.index', $lead)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Lead $lead): View
    {
        $this->authorize('view', $lead);

        $stages = Stage::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $contracts = Contract::pluck('name', 'id');
        $cards = Card::get();
        $comments = $lead->comments()->latest()->get();
        $addresses = $lead->addresses()->latest()->get();
        $authenticatedUser = Auth::user();
        $deals = Deal::with('status')->get();

        $ddeals = Deal::where('lead_id', $lead->id)->get();
        $lastDeal = $ddeals->last();

        $statuses = Status::get();


        //Statistics
        $stadeals = Deal::where('lead_id', $lead->id)->withCount('deal_cards')->get();
        $allCards = $stadeals->sum('deal_cards_count') ?? 0;

        $shippingNum = $ddeals->where('status_id', 4)->count() ?? 0;
        $receptionsNum = $ddeals->where('status_id', 5)->count() ?? 0;

        $totalPrice = 0;
        foreach ($ddeals as $deal) {
            $totalPrice += $deal->deal_cards->count() * $deal->cost;
        }


        return view('app.leads.show', compact(
            'lead',
            'stages',
            'users',
            'contracts',
            'cards',
            'comments',
            'addresses',
            'authenticatedUser',
            'deals',
            'ddeals',
            'lastDeal',
            'statuses',
            'allCards',
            'shippingNum',
            'receptionsNum',
            'totalPrice'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Lead $lead): View
    {
        $this->authorize('update', $lead);

        $stages = Stage::pluck('name', 'id');
        $sources = Source::pluck('name', 'id');
        $contracts = Contract::pluck('name', 'id');
        $cards = Card::pluck('name', 'id');


        return view(
            'app.leads.edit',
            compact('lead', 'stages', 'contracts', 'cards', 'sources')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        LeadUpdateRequest $request,
        Lead $lead
    ): RedirectResponse {
        $this->authorize('update', $lead);

        $validated = $request->validated();

        $lead->update($validated);
        //$lead->users()->sync($validated['user_ids']);

        return redirect()
            ->route('leads.index', $lead)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Lead $lead): RedirectResponse
    {
        $this->authorize('delete', $lead);

        $lead->delete();

        // Reload table data
        $leads = Lead::latest()->paginate(100);

        return redirect()
            ->route('leads.index')
            ->withSuccess(__('crud.common.removed'))
            ->with('leads', $leads); // Pass updated leads data
    }




    public function restore(Request $request, $id): RedirectResponse
    {
        $this->authorize('restore', Lead::class);

        $lead = Lead::onlyTrashed()->findOrFail($id);
        $lead->restore();

        return redirect()
            ->route('leads.archive')
            ->withSuccess(__('crud.common.restored'));
    }



    public function updateUsers(Request $request, Lead $lead): RedirectResponse
    {
        $this->authorize('update', $lead);

        $validated = $request->validate([
            'user_ids' => 'array|exists:users,id',
        ]);

        $lead->users()->sync($validated['user_ids']);

        return redirect()
            ->route('leads.show', $lead)
            ->withSuccess(__('crud.common.saved'));
    }

    public function archive(Request $request): View
    {

        $this->authorize('view-any', Lead::class);

        $search = $request->get('search', '');

        $leads = Lead::onlyTrashed()
            ->when($search, function ($query) use ($search) {
                return $query->search($search);
            })
            ->latest()
            ->paginate(100)
            ->withQueryString();
        $stages = Stage::pluck('name', 'id');
        $contracts = Contract::pluck('name', 'id');
        $cards = Card::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view('app.leads.archive', compact('leads', 'search', 'stages', 'contracts', 'cards', 'users'));
    }


    public function forceDelete($id)
    {
        // Retrieve the lead by its ID, even if it's soft deleted
        $lead = Lead::withTrashed()->findOrFail($id);

        // Permanently delete the lead
        $lead->forceDelete();

        // Redirect or return a response after successful deletion
      
        return redirect()
            ->route('leads.archive')->with('success', 'Lead permanently deleted.');
    }

    public function convertLeads(Request $request)
    {
        // dd($request->all());
        // Validate the incoming request data
        $validated = $request->validate([
            'lead_id' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'stage_id' => 'nullable|exists:stages,id',
            'same_status' => 'nullable',
            'new_status' => 'nullable',
        ]);

        // Extract validated data
        $leadIds = explode(',', $validated['lead_id']);
        $userId = $validated['user_id'];
        $stageId = $validated['stage_id'];
        $sameStatus = $validated['same_status'];
        $newStatus = $validated['new_status'];

        foreach ($leadIds as $leadId) {
            $lead = Lead::find($leadId);

            if ($lead) {
                if ($sameStatus == 'true') {
                    $stageId = $lead->stage_id;
                } else {
                    $stageId = Stage::where('name', 'new')->pluck('id')->first();
                }
                $lead->stage_id = $stageId;
                $lead->save();

                $lead->users()->sync([$userId]);
            }
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
        }

        // return redirect()->route('leads.index')->with('success', 'Leads converted successfully.');
        return back()->with('success', 'Leads converted successfully.');
        
    }



    public function archiveall(LeadUpdateRequest $request): RedirectResponse
    {
        $leadIds = explode(',', $request->input('lead_id')); // Get array of lead IDs
    
        foreach ($leadIds as $leadId) {
            // Find the lead by ID
            $lead = Lead::find($leadId);
            
            // Check if lead exists and has no associated deals
            if ($lead && ! $lead->deals()->exists()) {
                // Update deleted_at field with a specific timestamp using Carbon
                $lead->update(['deleted_at' => Carbon::parse('2024-09-05 12:03:27')]);
            }
        }
    
        // Redirect or handle response after processing
        return redirect()->route('leads.index')->with('success', 'Leads archived successfully.');
    }
    public function download_template()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return response()->download(storage_path('app/public/lead_template.xlsx'), 'lead_template.xlsx');
    }
    public function export()
    {
        return Excel::download(new LeadsExport, 'leads.xlsx');
    }

    public function import(Request $request)
    {

        $request->validate([
            'file' => 'required' // Validation rule to ensure a file is uploaded
        ]);

        try {
            Excel::import(new LeadsImport, $request->file('file')); // Import the file using Laravel Excel
            return redirect()->route('leads.index')->with('success', 'Leads imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }

    // public function import(Request $request)
    // {
    //     if ($request->hasFile('file')) {
    //         try {
    //             Excel::import(new LeadsImport, $request->file('file'));
    //             session()->flash('success', __('Patients imported successfully'));
    //         } catch (ValidationException $e) {
    //             session()->flash('error', __('Validation error: ' . $e->getMessage()));
    //         } catch (\Exception $e) {
    //             session()->flash('error', __('Error occurred while importing patients: ' . $e->getMessage()));
    //         }
    //     } else {
    //         session()->flash('error', __('No file uploaded'));
    //     }

    //     return redirect()->route('leads.index')->with('success', 'Leads imported successfully.');
    // }


}
