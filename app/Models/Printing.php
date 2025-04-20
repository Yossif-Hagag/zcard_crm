<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Printing extends Model
{
    use HasFactory;
    use Searchable;
    protected $fillable = [
        'lead_id',
        'delivery_date',
        'cost',
        'customer_address',
        'defaultname',
        'defaultphone',
        'time',
        'status_id'
    ];

    protected $searchableFields = ['*'];


    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function print_cards()
    {
        return $this->hasMany(PrintCard::class, 'print_id');
    }
}
