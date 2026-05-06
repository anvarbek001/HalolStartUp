<?php

namespace App\Repositories;

use App\Models\PartiesHistory;
use App\Models\Party;
use Illuminate\Support\Facades\Auth;

class PartyRepository
{

    public function findByUserParty()
    {
        return Party::with('products')
            ->where('brand_id', Auth::user()->brand->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function partyHistory()
    {
        return PartiesHistory::orderBy('id', 'DESC')->cursorPaginate(20);
    }
}
