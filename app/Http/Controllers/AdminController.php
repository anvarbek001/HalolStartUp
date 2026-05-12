<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBrandStatusRequest;
use App\Models\Brand;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\BrandService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(UserRepository $userRepo, BrandService $service)
    {
        $service->userBrandCheck();
        $users = $userRepo->findUser();
        return view('admin.index', ['users' => $users]);
    }

    public function updateBrandStatus(UpdateBrandStatusRequest $request, Brand $brand)
    {
        $brand->update(['status' => $request->status]);
        return response()->json([
            'success' => true,
            'message' => 'Status yangilandi',
            'status'  => $brand->status,
        ]);
    }
}
