<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\PartiesHistoryController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionsController;
use App\Models\Brand;
use App\Models\Viloyat;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'brands' => Brand::all(),
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/brandRegister', [BrandController::class, 'index'])->middleware(['auth', 'verified'])->name('brandRegister');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store');

Route::get('/parties', [PartyController::class, 'index'])->name('parties');
Route::post('/parties/activated/{party_id}', [PartyController::class, 'activated'])->name('party.activated');
Route::post('/parties/store', [PartyController::class, 'store'])->name('parties.store');
Route::put('/parties/{party}', [PartyController::class, 'update'])->name('parties.update');
Route::delete('/party/delete/{id}', [PartyController::class, 'delete'])->name('party.delete');
Route::get('/download/shablon', [PartyController::class, 'shablon'])->name('download.shablon');

Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
Route::post('/products/check', [ProductController::class, 'check'])->name('products.check');

Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::patch('/admin/brand/{brand}/status', [AdminController::class, 'updateBrandStatus'])
    ->name('admin.brand.status');

Route::get('download/license/{brand_id}', [BrandController::class, 'downloadLicense'])->name('download.license');


Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['uz', 'ru', 'en'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');


Route::get('/histories', [PartiesHistoryController::class, 'index'])->name('histories');


require __DIR__ . '/auth.php';
