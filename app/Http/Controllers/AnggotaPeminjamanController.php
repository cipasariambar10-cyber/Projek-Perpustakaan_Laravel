<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;

class AnggotaPeminjamanController extends Controller
{
    /**
     * Controller riwayat peminjaman anggota — milik Hayfa.
     * Anggota hanya bisa melihat riwayat peminjaman sendiri.
     */

    /**
     * Riwayat peminjaman milik anggota yang sedang login.
     */
    public function index(Request $request)
    {
        $query = Loan::with('book')
                     ->where('user_id', auth()->id())
                     ->orderByDesc('created_at');

        // Filter status
        if ($request->filled('status')) {
            if ($request->status === 'terlambat') {
                $query->terlambat();
                // Juga pastikan milik user ini
                $query->where('user_id', auth()->id());
            } else {
                $query->where('status', $request->status);
            }
        }

        $peminjaman = $query->paginate(10)->withQueryString();

        return view('anggota.peminjaman', compact('peminjaman'));
    }
}
