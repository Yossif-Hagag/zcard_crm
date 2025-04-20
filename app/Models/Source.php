<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Source extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',

    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'follow_date' => 'date',
    ];


public function leads()
{
    return $this->hasMany(Lead::class);
}
}