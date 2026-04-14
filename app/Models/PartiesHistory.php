<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartiesHistory extends Model
{
    protected $fillable = [
        'user_id',
        'party_id',
        'before_changing_status',
        'after_changing_status',
        'date_changing',
    ];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }
}
