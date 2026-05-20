<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductShablonImportRequest;
use App\Http\Requests\QRCodeCheckRequest;
use App\Imports\ProductsImport;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function import(ProductShablonImportRequest $request)
    {
        try {
            Excel::import(new ProductsImport((int) $request->party_id), $request->file('file'));

            return redirect()->route('parties')->with('success', "Mahsulotlar muvaffaqiyatli kiritildi");
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('parties')->with('error', "Xatolik faylni qayta tekshiring");
        } catch (\Exception $e) {
            return redirect()->route('parties')->with('error', "Serverda xatolik");
        }
    }

    public function check(QRCodeCheckRequest $request, ProductService $service)
    {
        $product = $service->findProduct($request->qrcode);

        return response()->json([
            'success' => true,
            'party_name' => $product->party->name,
            'rating' => $product->party->rating,
            'description' => $product->party->description,
            'image' => asset('storage/' . $product->party->image),
            'brand_logo' => asset('storage/' . $product->party->brand->logo),
            'price' => $product->party->price
        ], 200);
    }
}
