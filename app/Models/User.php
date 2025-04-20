<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use BasementChat\Basement\Contracts\User as BasementUserContract;
use BasementChat\Basement\Traits\HasPrivateMessages;

class User extends Authenticatable implements BasementUserContract
{
    use HasRoles;
    use Notifiable;
    use HasFactory;
    use Searchable;
    use HasApiTokens;
    use HasPrivateMessages;

    protected $fillable = ['name', 'email', 'password', 'image', 'phone'];

    protected $searchableFields = ['*'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function leads()
    {
        return $this->belongsToMany(Lead::class);
    }

    public function deals()
    {
        return $this->belongsToMany(Deal::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function addresses()
    {
        return $this->belongsToMany(Address::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('Super Admin');
    }


    // public function getNameAttribute(): string
    // {
    //     return str($this->attributes['name'])->explode(' ')->last();
    // }

    public function parents()
    {
        return $this->belongsToMany(User::class, 'team', 'child_id', 'parent_id')
            ->withTimestamps();
    }

    public function childs()
    {
        return $this->belongsToMany(User::class, 'team', 'parent_id', 'child_id')
            ->withTimestamps();
    }
}
