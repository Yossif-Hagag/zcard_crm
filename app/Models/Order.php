<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_address',
        'cost',
        'order_date',
        'delivery_date',
        'status_id',
        'card_name',
        'lead_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'order_date' => 'date',
        'delivery_date' => 'date',
        'card_name' => 'array',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
