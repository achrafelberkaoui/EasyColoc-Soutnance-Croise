<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    protected $fillable = [
        'name',
        'owner_id',
        'status',
    ];
public function owner()
{
    return $this->belongsTo(User::class, 'owner_id');
}

public function membership()
{
    return $this->hasMany(Membership::class);
}

public function members()
{
    return $this->belongsToMany(User::class, 'memberships')
    ->withPivot('role', 'joined_at', 'left_at')->withTimestamps();
}

public function expenses()
{
    // return $this->hasMany(Expense::class);
}
}
