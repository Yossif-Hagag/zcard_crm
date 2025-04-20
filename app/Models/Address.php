<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['address', 'flat_number', 'floor', 'landmark','state','building','city'];

    protected $searchableFields = ['*'];

    public function leads()
    {
        return $this->belongsToMany(Lead::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
    
}
