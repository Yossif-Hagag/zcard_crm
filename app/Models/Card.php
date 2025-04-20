<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'cost', 'image','number'];

    protected $searchableFields = ['*'];

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }
}
