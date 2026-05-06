<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Models\Brand;
use App\Models\Viloyat;
use App\Repositories\BrandRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index()
    {
        return view('auth/brandRegister', [
            'viloyatlar' => Viloyat::all(),
        ]);
    }

    public function store(BrandStoreRequest $request, BrandRepository $brandRepo)
    {
        try {
            if ($request->hasFile('license')) {
                $nameLicense = time() . '_' . $request->file('license')->getClientOriginalName();
                $pathLicense = $request->file('license')->storeAs('licenses', $nameLicense, 'public');
            }
            if ($request->hasFile('logo')) {
                $nameLogo = time() . '_' . $request->file('logo')->getClientOriginalName();
                $pathLogo = $request->file('logo')->storeAs('logos', $nameLogo, 'public');
            }
            $order = 1;

            $brand = Brand::orderByDesc('order')->first();
            if ($brand) {
                $order = $brand->order + 1;
            }

            $brandName = $brandRepo->findBrand($request);

            if ($brandName) {
                return redirect()->route('brandRegister')->with('error', "Bunday brend nomi bazada mavjud");
            }

            Brand::create([
                'user_id' => Auth::user()->id,
                'viloyat_id' => $request->viloyat_id,
                'name' => $request->name,
                'license' => $pathLicense,
                'logo' => $pathLogo,
                'description' => $request->description,
                'order' => $order
            ]);

            return redirect()->route('dashboard')->with('success', "Brend ro'yxatdan o'tkazildi tasdiqlanishini kuting");
        } catch (\Throwable $th) {
            return redirect()->route('brandRegister')->with('error', "Xatolik" . $th->getMessage());
        }
    }

    public function downloadLicense($brand_id, BrandRepository $brandRepo)
    {
        $brand = $brandRepo->findOrFileBrand($brand_id);
        if (!$brand) {
            return response()->json(['message' => 'Brand topilmadi'], 404);
        }

        $filePath = storage_path('app/public/' . $brand->license);

        if (!file_exists($filePath)) {
            return back()->with('error', 'Fayl tizimda mavjud emas.');
        }

        return response()->download($filePath);
    }
}
