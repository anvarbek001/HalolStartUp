<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tuman extends Model
{
    protected $fillable = [
        'viloyat_id',
        'name',
        'order',
    ];

    public function viloyat(): BelongsTo
    {
        return $this->belongsTo(Viloyat::class);
    }
}
