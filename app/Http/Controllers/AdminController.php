<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->with(['brand', 'brand.parties.products'])
            ->where('id', '!=', Auth::user()->id)
            ->get();

        return view('admin.index', ['users' => $users]);
    }

    public function updateBrandStatus(Request $request, Brand $brand)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,pending,blocked',
        ]);

        $brand->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status yangilandi',
            'status'  => $brand->status,
        ]);
    }

    // public function help($userId = null)
    // {
    //     $users = User::where('id', '!=', Auth::user())->get();

    //     $messages = [];
    //     $selectedUser = null;

    //     if ($userId) {
    //         $selectedUser = User::findOrFail($userId);
    //         // Admin va tanlangan user o'rtasidagi xabarlar
    //         $messages = Message::where(function ($q) use ($userId) {
    //             $q->where('sender_id', auth()->id())->where('receiver_id', $userId);
    //         })->orWhere(function ($q) use ($userId) {
    //             $q->where('sender_id', $userId)->where('receiver_id', auth()->id());
    //         })->orderBy('created_at', 'asc')->get();
    //     }

    //     return view('admin.chat', compact('users', 'messages', 'selectedUser'));
    // }
}
