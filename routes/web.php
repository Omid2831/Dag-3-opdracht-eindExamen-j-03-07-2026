<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AfspraakController;
use App\Http\Controllers\KlantController;
use App\Http\Controllers\BehandelingController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'role:admin'])->name('admin.dashboard');


Route::get('/admin/afspraken', [AfspraakController::class, 'index'])->middleware(['auth', 'role:admin'])->name('admin.afspraken');




Route::get('/admin/klanten', [KlantController::class, 'index'])->middleware(['auth', 'role:admin'])->name('admin.klanten');




Route::get('/admin/behandelingen', [BehandelingController::class, 'index'])->middleware(['auth', 'role:admin'])->name('admin.behandelingen');




Route::get('/admin/producten', [ProductController::class, 'index'])->middleware(['auth', 'role:admin'])->name('admin.producten');
Route::get('/admin/producten/{id}', [ProductController::class, 'show'])->middleware(['auth', 'role:admin'])->name('admin.producten.show');
Route::get('/admin/producten/{id}/edit', [ProductController::class, 'edit'])->middleware(['auth', 'role:admin'])->name('admin.producten.edit');
Route::post('/admin/producten/{id}', [ProductController::class, 'update'])->middleware(['auth', 'role:admin'])->name('admin.producten.update');


Route::get('/manager/dashboard', function () {
    return view('manager.dashboard');
})->middleware(['auth', 'role:manager'])->name('manager.dashboard');

Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth', 'role:user'])->name('dashboard');

Route::get('/loadbar', function () {
    $user = request()->user();
    $intended = session('url.intended');
    $loadbarUrl = route('loadbar');

    if ($intended && $intended !== $loadbarUrl) {
        $redirectTo = $intended;
    } else {
        $redirectTo = match (true) {
            $user?->isAdmin() && Route::has('admin.dashboard') => route('admin.dashboard'),
            $user?->isManager() && Route::has('manager.dashboard') => route('manager.dashboard'),
            default => route('dashboard'),
        };
    }

    session()->forget('url.intended');

    return view('loadbar', [
        'redirectTo' => $redirectTo,
        'delayMs' => 3000,
    ]);
})->middleware('auth')->name('loadbar');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
