<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class payment extends Model
{
    protected $fillable = [
        'colocation_id', 'is_paid',
        'amount', 'to_user_id', 'from_user_id', 'expense_id'
    ];

public function fromUser()
{
    return $this->BelongsTo(User::class, 'from_user_id');
}
public function toUser()
{
    return $this->BelongsTo(User::class, 'to_user_id');
}
public function colocation()
{
    return $this->BelongsTo(Colocation::class);
}
public function expense()
{
    return $this->belongsTo(Expense::class);
}
}
