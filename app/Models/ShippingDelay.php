<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ShippingDelay extends Model
{
    use HasFactory;
    protected $table = "shipping_delay";
    protected $fillable = [
        'shipping_id',
        'deal_id',
        'date',
        'reason',
        'status'
    ];

    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }
}
