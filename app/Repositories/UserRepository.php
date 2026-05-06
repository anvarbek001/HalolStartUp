<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function findUser()
    {
        return User::query()
            ->with(['brand', 'brand.parties.products'])
            ->where('id', '!=', Auth::user()->id)
            ->get();
    }
}
