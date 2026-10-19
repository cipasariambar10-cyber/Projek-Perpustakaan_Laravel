<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;

class BerandaController extends Controller
{
    /**
     * Halaman beranda publik.
     * Menampilkan buku terbaru & populer.
     */
    public function index()
    {
        $bukuTerbaru = collect();
        $bukuPopuler = collect();
        $totalBuku = 0;
        $totalAnggota = 0;

        try {
            $totalAnggota = User::where('role', 'anggota')->where('status', 'aktif')->count();
            $totalBuku = Book::count();
            $bukuTerbaru = Book::orderByDesc('created_at')->limit(10)->get();
            $bukuPopuler = Book::withCount('loans')
                ->orderByDesc('loans_count')
                ->limit(10)
                ->get();
        } catch (\Throwable $e) {
            // Fallback jika belum ada data atau tabel
        }

        return view('beranda', compact('bukuTerbaru', 'bukuPopuler', 'totalBuku', 'totalAnggota'));
    }
}
