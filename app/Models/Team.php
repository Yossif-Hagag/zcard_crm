<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Team extends Pivot
{
    // Defining the relationship to the parent user
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    // Defining the relationship to the child user
    public function child()
    {
        return $this->belongsTo(User::class, 'child_id');
    }
}
