<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBrandStatusRequest;
use App\Models\Brand;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(UserRepository $userRepo)
    {
        $user = Auth::user();

        if (!$user->brand->id) {
            return redirect()->route('brandRegister')->with('error', "Foydalanuvchida brend ro'yxatga olinmagan");
        };

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
