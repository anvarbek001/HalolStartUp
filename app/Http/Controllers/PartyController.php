<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartyController extends Controller
{
    public function index()
    {
        $parties = Party::with('products')
            ->where('brand_id', Auth::user()->brand->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('parties.index', [
            'parties' => $parties
        ]);
    }
}
