<?php

namespace App\Http\Controllers;

use App\Enums\BrendStatus;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Party;
use App\Models\User;
use App\Services\BrandService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(BrandService $service)
    {
        $thisMonth = Customer::whereMonth('created_at', now()->month)->count();
        $lastMonth = Customer::whereMonth('created_at', now()->subMonth()->month)->count();
        $change = $lastMonth > 0 ? round((($thisMonth - $lastMonth) / $lastMonth) * 100) : 0;

        $stats = [
            [
                'id' => 1,
                'label' => 'Foydalanuvchilar',
                'value' => Customer::count(),
                'change' => $change,
                'progress' => 75,
                'progressColor' => 'bg-blue-500',
                'iconBg' => 'bg-blue-50 dark:bg-blue-900/20',
                'icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>',
            ],
            [
                'id' => 2,
                'label' => 'Brendim',
                'value' => Brand::where('user_id', Auth::user()->id)->where('status', BrendStatus::ACTIVE->value)->count(),
                'change' => 100,
                'progress' => 100,
                'progressColor' => 'bg-emerald-500',
                'iconBg' => 'bg-emerald-50 dark:bg-emerald-900/20',
                'icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
            ],
            [
                'id' => 3,
                'label' => 'Partiyalarim',
                'value' => Party::where('user_id', Auth::user()->id)->count(),
                'change' => 100,
                'progress' => 100,
                'progressColor' => 'bg-purple-500',
                'iconBg' => 'bg-purple-50 dark:bg-purple-900/20',
                'icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0v10l-8 4m8-14l-8 4m0 0L4 7m8 4v10M4 7v10l8 4"/></svg>',
            ],

        ];
        $service->userBrandCheck();
        return view('dashboard', [
            'stats' => $stats
        ]);
    }
}
