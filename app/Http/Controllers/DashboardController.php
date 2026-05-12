<?php

namespace App\Http\Controllers;

use App\Services\BrandService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(BrandService $service)
    {
        $service->userBrandCheck();
        return view('dashboard');
    }
}
