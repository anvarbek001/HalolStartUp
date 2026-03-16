<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = [
        'user_id',
        'viloyat_id',
        'name',
        'license',
        'logo',
        'rating',
        'status',
        'description',
        'order',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function viloyat(): BelongsTo
    {
        return $this->belongsTo(Viloyat::class);
    }

    public function parties(): HasMany
    {
        return $this->hasMany(Party::class);
    }
}
