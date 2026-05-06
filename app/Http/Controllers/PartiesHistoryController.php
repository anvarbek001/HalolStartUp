<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PartiesHistory;
use App\Repositories\PartyRepository;
use Illuminate\Http\Request;

class PartiesHistoryController extends Controller
{
    public function index(PartyRepository $partyRepo)
    {
        $histories = $partyRepo->partyHistory();
        return view('parties.histories', [
            'histories' => $histories
        ]);
    }
}
