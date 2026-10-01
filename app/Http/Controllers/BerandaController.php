<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    /**
     * Halaman beranda publik.
     * Menampilkan buku terbaru & populer (jika tabel books sudah ada).
     */
    public function index()
    {
        $bukuTerbaru = collect();
        $bukuPopuler = collect();
        $totalBuku = 0;
        $totalAnggota = User::where('role', 'anggota')->where('status', 'aktif')->count();

        try {
            if (\Schema::hasTable('books')) {
                $bukuTerbaru = \DB::table('books')->orderByDesc('created_at')->limit(8)->get();
                $totalBuku = \DB::table('books')->count();

                // Buku populer berdasarkan jumlah peminjaman
                if (\Schema::hasTable('loans')) {
                    $bukuPopuler = \DB::table('books')
                        ->leftJoin('loans', 'books.id', '=', 'loans.book_id')
                        ->select('books.*', \DB::raw('COUNT(loans.id) as total_pinjam'))
                        ->groupBy('books.id')
                        ->orderByDesc('total_pinjam')
                        ->limit(8)
                        ->get();
                } else {
                    $bukuPopuler = \DB::table('books')->inRandomOrder()->limit(8)->get();
                }
            }
        } catch (\Exception $e) {
            // Tabel books belum dibuat oleh Nasya
        }

        return view('beranda', compact('bukuTerbaru', 'bukuPopuler', 'totalBuku', 'totalAnggota'));
    }
}
