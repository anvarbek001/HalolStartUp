<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    public function click(Request $request)
    {
        $amount = $request->get('amount');
        $cardType = $request->get('card_type');

        // Click sahifasiga redirect
        $url = 'https://my.click.uz/services/pay?' . http_build_query([
            'amount'            => $amount,
            'merchant_id'       => env('CLICK_MERCHANT_ID'),
            'merchant_user_id' => Auth::user()->id,
            'service_id'        => env('CLICK_SERVICE_ID'),
            'transaction_param' => Auth::user()->id,
            'card_type' => $cardType,
            'return_url'        => url('/dashboard'),
        ]);

        dd($url);

        return redirect($url);
    }
}
