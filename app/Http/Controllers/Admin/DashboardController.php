<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Halaman dashboard admin.
     * Statistik lengkap dikerjakan Nasya di hari ke-5.
     * Ini menyediakan statistik dasar anggota.
     */
    public function index()
    {
        $stats = [
            'total_anggota' => User::where('role', 'anggota')->count(),
            'anggota_aktif' => User::where('role', 'anggota')->where('status', 'aktif')->count(),
            'total_admin' => User::where('role', 'admin')->count(),
            'total_buku' => 0,
            'total_dipinjam' => 0,
            'total_terlambat' => 0,
        ];

        // Total buku (milik Nasya)
        $stats['total_buku'] = Book::count();

        // Load statistik peminjaman jika tabel sudah ada (milik Hayfa)
        try {
            if (\Schema::hasTable('loans')) {
                $stats['total_dipinjam'] = \DB::table('loans')->where('status', 'dipinjam')->count();
                $stats['total_terlambat'] = \DB::table('loans')
                    ->where('status', 'dipinjam')
                    ->whereDate('batas_kembali', '<', now()->toDateString())
                    ->count();
            }
        } catch (\Exception $e) {
            // Tabel belum ada
        }

        // Anggota terbaru (5 terakhir)
        $anggotaTerbaru = User::where('role', 'anggota')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'anggotaTerbaru'));
    }
}
