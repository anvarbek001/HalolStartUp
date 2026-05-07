<?php

namespace App\Http\Controllers;

use App\Enums\PartyStatus;
use App\Enums\PaymentStatus;
use App\Http\Requests\PartyStoreRequest;
use App\Http\Requests\PartyUpdateRequest;
use App\Http\Requests\ShablonRequest;
use App\Imports\ProductsImport;
use App\Models\Brand;
use App\Models\PartiesHistory;
use App\Models\Party;
use App\Models\UserBalance;
use App\Repositories\BrandRepository;
use App\Repositories\PartyRepository;
use App\Services\PartyService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class PartyController extends Controller
{
    public function index(BrandRepository $brandRepo, PartyRepository $partyRepo)
    {
        $parties = $partyRepo->findByUserParty();
        $brand = $brandRepo->findByUser();
        return view('parties.index', [
            'parties' => $parties,
            'brand'  => $brand,
        ]);
    }

    public function store(PartyStoreRequest $request, PartyService $service)
    {
        $service->partyStore($request);
        return redirect()->route('parties')->with('success', "Partiya qo'shildi");
    }

    public function shablon(ShablonRequest $request)
    {
        $path = public_path('storage/shablon/Shablon.xlsx');

        if (!file_exists($path)) {
            return response()->json([
                'success' => false,
                'message' => "Fayl topilmadi"
            ]);
        }

        return response()->download($path, 'Shablon.xlsx');
    }

    public function update(PartyUpdateRequest $request, Party $party)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'price'            => 'nullable|numeric|min:0',
            'rating'           => 'nullable|numeric|min:1|max:5',
            'description'      => 'required|string',
            'manufactured_at'  => 'nullable|date',
            'expires_at'       => 'nullable|date',
            'image'            => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($party->image) Storage::delete($party->image);
            $validated['image'] = $request->file('image')->store('parties', 'public');
        }

        $party->update($validated);

        return back()->with('success', 'Partiya muvaffaqiyatli yangilandi!');
    }

    public function delete($id)
    {
        if (!$id) {
            return redirect()->route('parties')->with('error', "Partya topilmadi");
        }

        $part = Party::where('id', $id)->with('products')->first();
        if ($part->user_id != Auth::user()->id) {
            return redirect()->route('parties')->with('error', "Bu partiya ustida amal bajara olish huquqiga ega emassiz");
        }
        if ($part->image) {
            Storage::delete($part->image);
        }
        $part->delete();
        return redirect()->route('parties')->with('success', "Partiya muvaffaqiyatli o'chirildi");
    }

    public function activated(Request $request, $party_id)
    {
        $party = Party::where('id', $party_id)->first();

        if ($party->user_id !== Auth::user()->id) {
            abort(403, "Ruxsat yo'q");
        }

        if ($party->status == 'inactive') {
            if ($party->payment_status == PaymentStatus::UNPAID->value) {
                $productCount = count($party->products);
                if ($productCount <= 0) {
                    return back()->with('error', "Partiyani faolashtirish uchun mahsulot qo'shing");
                }
                $productPrice = ($party->price * 0.01);
                $allPrice = $productPrice * $productCount;
                $userBalance = Auth::user()->userBalance->balance ?? 0;
                if ($userBalance <= 0) {
                    return back()->with('error', "Partiyani faolashtirish hisobni to'ldiring");
                }
                $result = ($userBalance - $allPrice);
                $neededPrice = $allPrice - $userBalance;
                number_format($neededPrice, 0, '.', ' ');
                if ($result < 0) {
                    return back()->with('error', "Hisobingizda $neededPrice so'm mablag' yetarli emas");
                }
                $party->payment_status = PaymentStatus::PAID->value;
                $party->status = 'active';
                $party->save();
                $balance = UserBalance::where('user_id', Auth::user()->id)->first();
                $balance->update([
                    'balance' => $result,
                ]);
            } else {
                $party->status = 'active';
                PartiesHistory::create([
                    'user_id' => Auth::user()->id,
                    'party_id' => $party_id,
                    'before_changing_status' => 'inactive',
                    'after_changing_status' => 'active',
                    'date_changing' => Carbon::now(),
                ]);
                $party->save();
            }
            return back()->with('success', 'Partiya faollashtirildi');
        } elseif ($party->status == 'active') {
            $party->status = 'inactive';
            PartiesHistory::create([
                'user_id' => Auth::user()->id,
                'party_id' => $party_id,
                'before_changing_status' => 'active',
                'after_changing_status' => 'inactive',
                'date_changing' => Carbon::now(),
            ]);
            $party->save();
            return back()->with('success', 'Partiya faolsizlantirildi');
        }
    }
}
