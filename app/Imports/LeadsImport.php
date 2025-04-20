<?php



namespace App\Imports;

use App\Models\Lead;
use App\Models\Source;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LeadsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
      
        $name = !empty(trim($row['name'])) ? strtolower(trim($row['name'])) : 'New Lead '.auth()->user()->name;
        $phone = trim($row['phone']);
        $phone2 = trim($row['phone2'] ?? '');
        $Source = trim($row['source'] ?? '');
        if (empty($row['name']) ||empty($row['phone']) ) {
        
                    return null; 
        }
        
        $source = Source::where('name', $Source)->first();
       
        if (!$source) {
                    // Handle case where source does not exist, e.g. create it or return a null lead
              return null; // Or handle this differently based on your requirements
        }
        $source_id = $source->id;
        // Check if the user has a role of 'Director' or 'Team Leader'
        if (Auth::user()->hasRole('Director') || Auth::user()->hasRole('Team Leader')) {
            // Create a lead with the authenticated user's ID
         
            $lead = Lead::create([
                'name' => $name,
                'phone' => $phone,
                'phone2' => $phone2,
                'stage_id' => 1, 
                'source_id' =>$source_id, 
          
            ]);
           
            $lead->users()->sync([Auth::user()->id]);
        } else {
         
            // Create a lead with no assigned user (user_id is null)
            $lead = Lead::create([
                'name' => $name,
                'phone' => $phone,
                'phone2' => $phone2,
                'stage_id' => 1, // Default stage ID
                'source_id' => $source_id, // Default source ID
           
            ]);
        }

        // Return the created lead
        return $lead;
    }
}
// public function model(array $row)
// {
//     // Clean up and prepare the data
//     $name = !empty(trim($row['name'])) ? strtolower(trim($row['name'])) : 'New Lead ' . auth()->user()->name;
//     $phone = trim($row['phone']);
//     $phone2 = trim($row['phone2'] ?? '');

//     // Check if a lead with the same phone number or phone2 already exists
//     $existingLead = Lead::where('phone', $phone)
//                         ->orWhere('phone2', $phone2)
//                         ->first();

//     if ($existingLead) {
        
//         return null; 
//     }

//     // If the lead doesn't exist, create a new lead
//     if (Auth::user()->hasRole('Director') || Auth::user()->hasRole('Team Leader')) {
//         $lead = Lead::create([
//             'name' => $name,
//             'phone' => $phone,
//             'phone2' => $phone2,
//             'stage_id' => 1,  // Default stage ID
//             'source_id' => 1, // Default source ID
//         ]);
//         $lead->users()->sync([Auth::user()->id]);
//     } else {
//         $lead = Lead::create([
//             'name' => $name,
//             'phone' => $phone,
//             'phone2' => $phone2,
//             'stage_id' => 1,  // Default stage ID
//             'source_id' => 1, // Default source ID
//         ]);
//     }

//     return $lead;
// }

