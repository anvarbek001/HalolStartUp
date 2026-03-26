<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Brand::where('status', 'active')->get()->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->name,
                'rating' => $brand->rating,
                'license' => $brand->license ? asset('storage/' . $brand->license) : null,
                'logo'    => $brand->logo ? asset('storage/' . $brand->logo) : null,
                'description' => $brand->description
            ];
        });

        return response()->json($brands);
    }
}
