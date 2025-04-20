<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renew extends Model
{
    use HasFactory;

    protected $fillable = [
        'deal_id',
        'lead_id',
        'renew_time',
        'deal_renew_id',
        'price',
        'card_name',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'renew_time' => 'datetime',

    ];

    /**
     * Get the deal that owns the renewal.
     */
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }
}
