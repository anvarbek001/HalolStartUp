<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function findProductByQrCode(string $qrcode): ?Product
    {
        return Product::where('qrcode_number', $qrcode)->first();
    }

    public function findProductByBarCode(string $qrcode): ?Product
    {
        return Product::where('barcode_number', $qrcode)->first();
    }
}
