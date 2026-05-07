<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\Party;
use App\Repositories\BrandRepository;
use App\Repositories\PartyRepository;
use Illuminate\Support\Facades\Auth;

class PartyService
{
    public function __construct(protected BrandRepository $brandRepo, protected PartyRepository $partyRepo) {}

    public function partyStore($request)
    {
        $path = null;
        if ($request->hasFile('image')) {
            $name = time() . '_' . $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('brandImages', $name, 'public');
        }

        $userId = Auth::id();
        $brandId = Auth::user()->brand->id;

        // Order va uniq_id ni DB dan hisoblash (race condition yo'q)
        $lastParty = Party::where('brand_id', $brandId)->latest('order')->first();

        $order  = $lastParty ? $lastParty->order + 1 : 1;
        $uniqId = $lastParty ? $lastParty->uniq_id + 1 : $brandId . '001';

        $this->partyRepo->partyCreate([
            'user_id'     => $userId,
            'brand_id'    => $brandId,
            'name'        => $request->name,
            'description' => $request->description,
            'order'       => $order,
            'image'       => $path,
            'uniq_id'     => $uniqId,
            'price'       => $request->price,
        ]);
    }
}
