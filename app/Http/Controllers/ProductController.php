<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function import(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'file'     => 'required|mimes:xlsx,xls',
                'party_id' => 'required|exists:parties,id',
            ]);

            Excel::import(new ProductsImport((int) $request->party_id), $request->file('file'));

            return redirect()->route('parties')->with('success', "Mahsulotlar muvaffaqiyatli kiritildi");
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('parties')->with('error', "Xatolik faylni qayta tekshiring");
        } catch (\Exception $e) {
            return redirect()->route('parties')->with('error', "Serverda xatolik");
        }
    }

    public function check(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'qrcode' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
            ], 422);
        }

        $product = Product::where('qrcode_number', $request->qrcode)->first();

        if (!$product) {
            return response()->json([
                'success' => false,
            ], 400);
        }

        if ($product->party->status == 'inactive') {
            return response()->json([
                'success' => false,
            ], 400);
        }

        $product->scan_count += 1;
        $product->save();

        return response()->json([
            'success' => true,
            'party_name' => $product->party->name,
            'rating' => $product->party->rating,
            'description' => $product->party->description,
            'image' => asset('storage/logos/' . $product->party->image),
            'price' => $product->party->price
        ], 200);
    }
}
