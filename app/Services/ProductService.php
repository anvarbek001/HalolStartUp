<?php

namespace App\Services;

use App\Enums\PartyStatus;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    public function __construct(protected ProductRepository $prodRepo) {}

    public function findProduct($qrcode)
    {
        $qrcode = trim($qrcode);
        $product = Cache::get($qrcode);

        if (!$product) {
            $product = $this->prodRepo->findProductByQrCode($qrcode);
        }

        if (!$product) {
            $product = $this->prodRepo->findProductByBarCode($qrcode);
        }

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => "Mahsulot topilmadi"
            ], 400);
        }

        $product->increment('scan_count');
        Cache::put($qrcode, $product, now()->addHours(24));

        if ($product->party->status == PartyStatus::INACTIVE->value) {
            return response()->json([
                'success' => false,
                'message' => "Mahsulot bazamizda mavjud ammo faol holatda emas"
            ], 400);
        }

        return $product;
    }
}
