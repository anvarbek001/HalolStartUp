<?php

namespace App\Services;

use App\Repositories\BrandRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class BrandService
{
    public function __construct(protected BrandRepository $brandRepo) {}

    public function fileUpload($request)
    {
        $result = [];
        if ($request->hasFile('license')) {
            $result['license'] = $request->file('license')
                ->storeAs('licenses', time() . '_' . $request->file('license')->getClientOriginalName(), 'public');
        }

        if ($request->hasFile('logo')) {
            $result['logo'] = $request->file('logo')
                ->storeAs('logos', time() . '_' . $request->file('logo')->getClientOriginalName(), 'public');
        }

        return $result;
    }

    public function checkBrandName($name)
    {
        $normalized = mb_strtolower(trim($name));

        if ($this->brandRepo->findBrandByNormalizedName($normalized)) {
            throw new \Exception("Bunday brend nomi bazada mavjud");
        }
    }

    public function getNextOrder(): int
    {
        $brand = $this->brandRepo->getLastByOrder();
        return $brand ? $brand->order + 1 : 1;
    }

    public function createBrand(array $data)
    {
        return $this->brandRepo->brandCreate($data);
    }

    public function userBrandCheck()
    {
        $user = Auth::user();

        if (!$user->brand || !$user->brand->id) {
            return redirect()->route('brandRegister');
        }
    }
}
