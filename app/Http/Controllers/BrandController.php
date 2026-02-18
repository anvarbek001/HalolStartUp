<?php

namespace App\Http\Controllers;

use App\Models\Viloyat;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        return view('auth/brandRegister', [
            'viloyatlar' => Viloyat::all(),
        ]);
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
