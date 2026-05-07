<?php

namespace App\Repositories;

use App\Models\Brand;
use Illuminate\Support\Facades\Auth;

class BrandRepository
{
    public function findBrand($name)
    {
        return Brand::where('name', $name)->first();
    }

    public function getLastByOrder()
    {
        return Brand::orderByDesc('order')->first();
    }

    public function findOrFileBrand($brand_id)
    {
        return Brand::findOrFail($brand_id);
    }

    public function findByUser()
    {
        return Brand::where('user_id', Auth::user()->id)->first();
    }

    public function brandCreate(array $data)
    {
        return Brand::create([
            'user_id' => Auth::user()->id,
            'viloyat_id' => $data['viloyat_id'],
            'name' => $data['name'],
            'license' => $data['license'],
            'logo' => $data['logo'],
            'description' => $data['description'],
            'order' => $data['order']
        ]);
    }
}
