<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Viloyat extends Model
{
    protected $fillable = [
        'name',
        'order',
    ];

    public function tumans(): HasMany
    {
        return $this->hasMany(Tuman::class);
    }

    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class);
    }
}
