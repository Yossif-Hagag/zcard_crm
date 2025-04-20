<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectShippingReasonShipping extends Model
{
    use HasFactory;

    protected $table = 'reject_shipping_reason_shipping';

    protected $fillable = [
        'reject_shipping_reason_id',
        'shipping_id',
        'other',
    ];


}
