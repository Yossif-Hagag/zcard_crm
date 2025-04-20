<?php

namespace App\Exports;

use App\Models\Contract;
use App\Models\Lead;
use App\Models\Source;
use Illuminate\Support\Facades\Auth;
use App\Models\Stage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class LeadsExport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // $leads = Lead::all();
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

            // Fetch leads based on the determined IDs
            $query->whereHas('users', function ($query) use ($checked) {
                $query->whereIn('users.id', $checked); // Use the IDs here
            });
        }

        // Execute the query to get the leads
        $leads = $query->get();

        // Prepare data for export
        $list = [];
        foreach ($leads as $lead) {
            $stage = Stage::find($lead->stage_id);
            $source = Source::find($lead->source_id);
            $contract = Contract::find($lead->contract_id);

            // Use 'null' as fallback if related data is not found
            $stage_name = $stage ? $stage->name : 'N/A';
            $source_name = $source ? $source->name : 'N/A';
            $contract_name = $contract ? $contract->name : 'N/A';

            $list[] = [
                $lead->name,
                $lead->phone,
                $lead->phone2,
                $lead->	follow_date,
                $stage_name,
                $contract_name,
                $source_name,
                $lead->created_at,
            ];
        }

        // Return as a collection
        return collect($list);


    }
    public function headings(): array
    {
        return [
            'Name',
            'Phone',
            'Phone 2',
            'Follow Date',
            'Stage',
            'Contract',
            'Source',
            'Created At',
        ];
    }
}
