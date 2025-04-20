<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\Searchable;

class RejectShippingReasons extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'reason',

    ];

    protected $searchableFields = ['*'];

    /**
     * The shippings that belong to the reject shipping reason.
     */
    public function shippings()
    {
        return $this->belongsToMany(Shipping::class, 'reject_shipping_reason_shipping', 'reject_shipping_reason_id', 'shipping_id');
    }
}
