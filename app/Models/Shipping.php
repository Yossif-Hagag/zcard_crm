<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'lead_id',
        'deal_id',
        'delivery_date',
        'cost',
        'customer_address',
        'defaultname',
        'defaultphone',
        'time',
        'shipping_status',
        'attempts',
        'delivery_status'
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
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function shipping_cards()
    {
        return $this->hasMany(ShippingCard::class, 'shipping_id');
    }
    public function rejectShippingReasons()
    {
        return $this->belongsToMany(RejectShippingReasons::class, 'reject_shipping_reason_shipping', 'shipping_id', 'reject_shipping_reason_id') ->withPivot('other');
    }
    public function shipping_delay()
    {
        return $this->hasMany(ShippingDelay::class);
    }
}
