<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use Illuminate\Http\Request;
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
}
