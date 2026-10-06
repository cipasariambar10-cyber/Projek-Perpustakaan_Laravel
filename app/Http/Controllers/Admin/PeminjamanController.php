<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Controller peminjaman — milik Hayfa.
     * Admin mencatat peminjaman & pengembalian.
     */

    /**
     * Daftar semua peminjaman (admin).
     * Fitur: filter status, pencarian anggota/buku, penanda terlambat.
     */
    public function index(Request $request)
    {
        $query = Loan::with(['user', 'book'])
                     ->orderByDesc('created_at');

        // Filter status
        if ($request->filled('status')) {
            if ($request->status === 'terlambat') {
                $query->terlambat();
            } else {
                $query->where('status', $request->status);
            }
        }

        // Pencarian nama anggota atau judul buku
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->whereHas('user', function ($u) use ($cari) {
                    $u->where('name', 'ilike', "%{$cari}%")
                      ->orWhere('nis_nip', 'ilike', "%{$cari}%");
                })->orWhereHas('book', function ($b) use ($cari) {
                    $b->where('judul', 'ilike', "%{$cari}%");
                });
            });
        }

        $peminjaman = $query->paginate(15)->withQueryString();

        // Statistik ringkas
        $stats = [
            'total'       => Loan::count(),
            'dipinjam'    => Loan::dipinjam()->count(),
            'dikembalikan'=> Loan::dikembalikan()->count(),
            'terlambat'   => Loan::terlambat()->count(),
        ];

        return view('admin.peminjaman.index', compact('peminjaman', 'stats'));
    }

    /**
     * Form catat peminjaman baru.
     */
    public function create()
    {
        $anggota = User::where('role', 'anggota')
                       ->where('status', 'aktif')
                       ->orderBy('name')
                       ->get();

        $buku = Book::where('stok', '>', 0)
                    ->orderBy('judul')
                    ->get();

        return view('admin.peminjaman.create', compact('anggota', 'buku'));
    }

    /**
     * Simpan peminjaman baru.
     * Lama pinjam: 7 hari. Stok berkurang otomatis.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date',
        ]);

        $book = Book::findOrFail($request->book_id);

        // Validasi stok
        if ($book->stok <= 0) {
            return back()->with('error', 'Stok buku "' . $book->judul . '" habis.')->withInput();
        }

        // Validasi: anggota sudah meminjam buku yang sama dan belum dikembalikan
        $sudahPinjam = Loan::where('user_id', $request->user_id)
                           ->where('book_id', $request->book_id)
                           ->where('status', 'dipinjam')
                           ->exists();

        if ($sudahPinjam) {
            return back()->with('error', 'Anggota masih meminjam buku ini.')->withInput();
        }

        $tanggalPinjam = Carbon::parse($request->tanggal_pinjam);

        // Buat peminjaman
        Loan::create([
            'user_id'        => $request->user_id,
            'book_id'        => $request->book_id,
            'tanggal_pinjam' => $tanggalPinjam,
            'batas_kembali'  => $tanggalPinjam->copy()->addDays(7),
            'status'         => 'dipinjam',
        ]);

        // Kurangi stok buku
        $book->decrement('stok');

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dicatat.');
    }

    /**
     * Detail peminjaman.
     */
    public function show(Loan $peminjaman)
    {
        $peminjaman->load(['user', 'book']);

        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Proses pengembalian buku.
     * Stok bertambah otomatis. Denda dihitung otomatis.
     */
    public function kembalikan(Loan $peminjaman)
    {
        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('warning', 'Buku sudah dikembalikan sebelumnya.');
        }

        $tanggalKembali = Carbon::today();
        $denda = 0;

        // Hitung denda jika terlambat (Rp1.000 per hari)
        if ($tanggalKembali->greaterThan($peminjaman->batas_kembali)) {
            $hariTerlambat = $tanggalKembali->diffInDays($peminjaman->batas_kembali);
            $denda = $hariTerlambat * 1000;
        }

        // Update status peminjaman
        $peminjaman->update([
            'tanggal_kembali' => $tanggalKembali,
            'denda'           => $denda,
            'status'          => 'dikembalikan',
        ]);

        // Tambah stok buku
        $peminjaman->book->increment('stok');

        $pesan = 'Buku berhasil dikembalikan.';
        if ($denda > 0) {
            $pesan .= ' Denda keterlambatan: Rp' . number_format($denda, 0, ',', '.');
        }

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', $pesan);
    }

    /**
     * Hapus data peminjaman.
     */
    public function destroy(Loan $peminjaman)
    {
        // Jika masih dipinjam, kembalikan stok
        if ($peminjaman->status === 'dipinjam') {
            $peminjaman->book->increment('stok');
        }

        $peminjaman->delete();

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
