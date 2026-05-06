<?php

namespace App\Repositories;

use App\Models\Brand;
use Illuminate\Support\Facades\Auth;

class BrandRepository
{
    public function findBrand($request)
    {
        return Brand::where('name', $request->name)->first();
    }

    public function findOrFileBrand($brand_id)
    {
        return Brand::findOrFail($brand_id);
    }

    public function findByUser()
    {
        return Brand::where('user_id', Auth::user()->id)->first();
    }
}
