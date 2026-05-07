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

    public function partyCreate(array $data)
    {
        return Party::create([
            'user_id' => $data['userId'],
            'brand_id' => $data['brandId'],
            'name' => $data['name'],
            'description' => $data['description'],
            'order' => $data['order'],
            'image' => $data['path'],
            'uniq_id' => $data['uniqId'],
            'price' => $data['price']
        ]);
    }
}
