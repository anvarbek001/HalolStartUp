<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PartiesHistory;
use Illuminate\Http\Request;

class PartiesHistoryController extends Controller
{
    public function index()
    {
        $histories = PartiesHistory::orderBy('id', 'DESC')->cursorPaginate(20);
        return view('parties.histories', [
            'histories' => $histories
        ]);
    }
}
