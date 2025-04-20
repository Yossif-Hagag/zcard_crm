<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealCard extends Model
{
    use HasFactory;

    // Define the table associated with the model if it's not the plural form of the model name
    protected $table = 'deal_cards';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'deal_id',
        'customer_name',
        'customer_phone',
        'card_name',
    ];

    // Define any relationships if necessary
    public function deal()
    {
        return $this->belongsTo(Deal::class, 'deal_id');
    }

    // Add any additional methods or scopes here
}
