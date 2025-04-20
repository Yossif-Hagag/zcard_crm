<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Deal extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'status_id',
        'lead_id',
        'deal_date',
        'delivery_date',
        'deal_date',
        'cost',
        'customer_address',
        'defaultname',
        'defaultphone',
        'time',
        'comment','status','renew'

    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'deal_date' => 'date',
        'delivery_date' => 'date',
        'card_name' => 'array',
    ];

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

    public function deal_cards()
    {
        return $this->hasMany(DealCard::class);
    }

    public function renews()
    {
        return $this->hasMany(Renew::class);
    }

}
