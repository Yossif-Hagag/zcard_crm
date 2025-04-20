<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'phone2',
        'stage_id',
        'source_id',
        'follow_date',
        'contract_id',
        'card_id',
        'deleted_at',
        'status_id',
        'follow_up_comment'
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'follow_date' => 'date',
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function addresses()
    {
        return $this->belongsToMany(Address::class);
    }

    public function lead()
{
    return $this->belongsTo(Lead::class);
}

}
