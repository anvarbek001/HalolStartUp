<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Party extends Model
{
    protected $fillable = [
        'user_id',
        'brand_id',
        'name',
        'rating',
        'description',
        'order',
        'image',
        'uniq_id',
        'manufactured_at',
        'expires_at',
        'price',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function partyStatus()
    {
        if ($this->status == 'inactive') {
            return '<span style="color:red;">Nofaol</span>';
        } elseif ($this->status == 'active') {
            return '<span style="color:green;">Faol</span>';
        }
    }

    public function partyStatusBtn()
    {
        if ($this->status == 'inactive') {
            return '<span style="color:green;">faollashtirish</span>';
        } elseif ($this->status == 'active') {
            return '<span style="color:red;">nofaollashtirish</span>';
        }
    }
}
