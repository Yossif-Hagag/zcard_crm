<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCard extends Model
{
    use HasFactory;

    protected $table = 'shipping_cards';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'shipping_id',
        'customer_name',
        'customer_phone',
        'card_name',
        'card_code',
    ];

    // Define any relationships if necessary
    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping_id');
    }
}
