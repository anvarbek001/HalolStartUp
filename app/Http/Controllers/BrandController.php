<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Models\Brand;
use App\Models\Viloyat;
use App\Repositories\BrandRepository;
use App\Services\BrandService;
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

    public function store(BrandStoreRequest $request, BrandService $service)
    {
        try {
            $service->checkBrandName($request->name);
            $files = $service->fileUpload($request);
            $service->createBrand([
                'viloyat_id' => $request->viloyat_id,
                'name' => $request->name,
                'license' => $files['license'],
                'logo' => $files['logo'],
                'description' => $request->description,
                'order' => $service->getNextOrder()
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
