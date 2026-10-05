<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\ProfilController;

/*
|--------------------------------------------------------------------------
| BERANDA — Halaman publik
|--------------------------------------------------------------------------
*/
Route::get('/', [BerandaController::class, 'index'])->name('beranda');

/*
|--------------------------------------------------------------------------
| KATALOG — Placeholder (milik Nasya)
|--------------------------------------------------------------------------
*/
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{book}', [KatalogController::class, 'show'])->whereNumber('book')->name('katalog.show');

/*
|--------------------------------------------------------------------------
| MODUL AKUN — Login, Register, Logout (milik Shyfha)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| PROFIL — Edit profil & ganti password (milik Shyfha)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('profil')->name('profil.')->group(function () {
    Route::get('/', [ProfilController::class, 'edit'])->name('edit');
    Route::put('/', [ProfilController::class, 'update'])->name('update');
    Route::put('/password', [ProfilController::class, 'updatePassword'])->name('password');
});

/*
|--------------------------------------------------------------------------
| ADMIN — Dashboard & CRUD Anggota (milik Shyfha)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Anggota
    Route::resource('anggota', AnggotaController::class);
    Route::patch('/anggota/{anggotum}/toggle-status', [AnggotaController::class, 'toggleStatus'])->name('anggota.toggle-status');
});

/*
|--------------------------------------------------------------------------
| MODUL BUKU — CRUD buku & kategori (milik Nasya)
| Nasya: tambahkan rute buku di sini
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('kategori', KategoriController::class)->except('show');
    Route::resource('buku', BukuController::class);
});

/*
|--------------------------------------------------------------------------
| MODUL PEMINJAMAN — Peminjaman & pengembalian (milik Hayfa)
| Hayfa: tambahkan rute peminjaman di sini
|--------------------------------------------------------------------------
*/
