<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Massenger extends Model
{
    use HasFactory;
    protected $fillable = ['massage_text', 'to','user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
