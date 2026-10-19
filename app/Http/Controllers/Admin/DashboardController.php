<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Halaman dashboard admin.
     * Statistik lengkap dikerjakan Nasya di hari ke-5.
     * Ini menyediakan statistik dasar anggota.
     */
    public function index()
    {
        $userStats = User::toBase()->selectRaw("
            COUNT(CASE WHEN role = 'anggota' THEN 1 END) as total_anggota,
            COUNT(CASE WHEN role = 'anggota' AND status = 'aktif' THEN 1 END) as anggota_aktif,
            COUNT(CASE WHEN role = 'admin' THEN 1 END) as total_admin
        ")->first();

        $stats = [
            'total_anggota' => (int) ($userStats->total_anggota ?? 0),
            'anggota_aktif' => (int) ($userStats->anggota_aktif ?? 0),
            'total_admin' => (int) ($userStats->total_admin ?? 0),
            'total_buku' => Book::count(),
            'total_dipinjam' => 0,
            'total_terlambat' => 0,
        ];

        try {
            $loanStats = Loan::toBase()->selectRaw("
                COUNT(CASE WHEN status = 'dipinjam' THEN 1 END) as total_dipinjam,
                COUNT(CASE WHEN status = 'dipinjam' AND batas_kembali < CURRENT_DATE THEN 1 END) as total_terlambat
            ")->first();

            if ($loanStats) {
                $stats['total_dipinjam'] = (int) ($loanStats->total_dipinjam ?? 0);
                $stats['total_terlambat'] = (int) ($loanStats->total_terlambat ?? 0);
            }
        } catch (\Throwable $e) {
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
