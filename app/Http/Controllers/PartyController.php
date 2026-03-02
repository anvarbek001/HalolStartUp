<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PartyController extends Controller
{
    public function index()
    {
        $parties = Party::with('products')
            ->where('brand_id', Auth::user()->brand->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $brand = Brand::where('user_id', Auth::user()->id)->first();
        return view('parties.index', [
            'parties' => $parties,
            'brand'  => $brand,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'rating' => 'nullable',
            'description' => 'string',
            'image' => 'required|mimes:jpg,png,jpeg,max:4096'
        ]);

        if ($validate->fails()) {
            return redirect()->route('parties')->with('error', "Ma'lumotlar to'liq emas qaytadan kiriting!");
        }

        if ($request->hasFile('image')) {
            $name = time() . '_' . $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('brandImages', $name, 'public');
        }

        $brand = Brand::where('user_id', Auth::user()->id)->latest()->first();
        $order = 0;
        $uniqId = Auth::user()->id . $brand->id;

        if ($brand) {
            $order = $brand->order + 1;
            $uniqId = $brand->uniq_id + 1;
        }

        $userId = Auth::user()->id;
        $brandId = Auth::user()->brand->id;

        Party::create([
            'user_id' => $userId,
            'brand_id' => $brandId,
            'name' => $request->name,
            'description' => $request->description,
            'order' => $order,
            'image' => $path,
            'uniq_id' => $uniqId,
            'price' => $request->price
        ]);

        return redirect()->route('parties')->with('success', "Partiya qo'shildi");
    }
}
