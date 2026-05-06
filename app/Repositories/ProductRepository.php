<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function findProductByQrCode($qrcode)
    {
        return Product::where('qrcode_number', $qrcode)->first();
    }
}
