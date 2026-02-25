<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Colocation;

class Invitation extends Model
{
    protected $fillable = [
        'email', 'token', 'status', 'colocation_id'
    ];

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }
}
