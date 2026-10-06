<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\AnggotaPeminjamanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\KatalogController;

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
Route::get('/katalog/{book}', [KatalogController::class, 'show'])->name('katalog.show');
Route::post('/katalog/{book}/pinjam', [KatalogController::class, 'pinjam'])->name('katalog.pinjam');

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

/*
|--------------------------------------------------------------------------
| MODUL PEMINJAMAN — Peminjaman & pengembalian (milik Hayfa)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::patch('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::delete('/peminjaman/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
});

// Riwayat peminjaman untuk anggota (hanya melihat)
Route::middleware('auth')->group(function () {
    Route::get('/anggota/peminjaman', [AnggotaPeminjamanController::class, 'index'])->name('anggota.peminjaman');
});
