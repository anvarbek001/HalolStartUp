<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'party_id',
        'qrcode_number',
        'barcode_number',
        'scan_count',
    ];

    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }
}
