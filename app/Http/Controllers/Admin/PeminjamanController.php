<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
            $operator = $query->getConnection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';
            $query->where(function ($q) use ($cari, $operator) {
                $q->whereHas('user', function ($u) use ($cari, $operator) {
                    $u->where('name', $operator, "%{$cari}%")
                        ->orWhere('nis_nip', $operator, "%{$cari}%");
                })->orWhereHas('book', function ($b) use ($cari, $operator) {
                    $b->where('judul', $operator, "%{$cari}%");
                });
            });
        }

        $peminjaman = $query->paginate(5)->withQueryString();

        // Statistik ringkas (1 query agregasi)
        $statsRaw = Loan::toBase()
            ->selectRaw("
                COUNT(*) as total,
                COUNT(CASE WHEN status = 'dipinjam' THEN 1 END) as dipinjam,
                COUNT(CASE WHEN status = 'dikembalikan' THEN 1 END) as dikembalikan,
                COUNT(CASE WHEN status = 'dipinjam' AND batas_kembali < CURRENT_DATE THEN 1 END) as terlambat
            ")
            ->first();

        $stats = [
            'total' => (int) ($statsRaw->total ?? 0),
            'dipinjam' => (int) ($statsRaw->dipinjam ?? 0),
            'dikembalikan' => (int) ($statsRaw->dikembalikan ?? 0),
            'terlambat' => (int) ($statsRaw->terlambat ?? 0),
        ];

        return view('admin.peminjaman.index', compact('peminjaman', 'stats'));
    }

    /**
     * Cetak laporan peminjaman & daftar buku berdasarkan rentang tanggal.
     */
    public function cetak(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'status' => ['nullable', 'in:dipinjam,dikembalikan,terlambat'],
        ], [
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
        ]);

        $tanggalMulai = $request->filled('tanggal_mulai')
            ? Carbon::parse($request->tanggal_mulai)->startOfDay()
            : null;
        $tanggalSelesai = $request->filled('tanggal_selesai')
            ? Carbon::parse($request->tanggal_selesai)->endOfDay()
            : null;

        $query = Loan::with(['user', 'book.category'])
            ->orderBy('tanggal_pinjam')
            ->orderBy('id');

        if ($tanggalMulai) {
            $query->whereDate('tanggal_pinjam', '>=', $tanggalMulai->toDateString());
        }

        if ($tanggalSelesai) {
            $query->whereDate('tanggal_pinjam', '<=', $tanggalSelesai->toDateString());
        }

        if ($request->filled('status')) {
            if ($request->status === 'terlambat') {
                $query->terlambat();
            } else {
                $query->where('status', $request->status);
            }
        }

        $peminjaman = $query->get();

        // Rekap daftar buku yang dipinjam dalam rentang tanggal tersebut
        $rekapBuku = $peminjaman
            ->filter(fn (Loan $loan) => $loan->book !== null)
            ->groupBy('book_id')
            ->map(function ($items) {
                $book = $items->first()->book;

                return [
                    'book' => $book,
                    'total_dipinjam' => $items->count(),
                    'masih_dipinjam' => $items->where('status', 'dipinjam')->count(),
                    'sudah_kembali' => $items->where('status', 'dikembalikan')->count(),
                ];
            })
            ->sortByDesc('total_dipinjam')
            ->values();

        // Ringkasan statistik pada periode laporan
        $ringkasan = [
            'total' => $peminjaman->count(),
            'dipinjam' => $peminjaman->where('status', 'dipinjam')->count(),
            'dikembalikan' => $peminjaman->where('status', 'dikembalikan')->count(),
            'terlambat' => $peminjaman->filter(fn (Loan $l) => $l->status === 'dipinjam' && $l->isTerlambat())->count(),
            'total_denda' => $peminjaman->sum(fn (Loan $l) => $l->status === 'dipinjam' ? $l->hitungDenda() : (int) $l->denda),
            'total_judul_buku' => $rekapBuku->count(),
        ];

        return view('admin.peminjaman.cetak', compact(
            'peminjaman',
            'rekapBuku',
            'ringkasan',
            'tanggalMulai',
            'tanggalSelesai'
        ));
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
            return back()->with('error', 'Stok buku "'.$book->judul.'" habis.')->withInput();
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
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'tanggal_pinjam' => $tanggalPinjam,
            'batas_kembali' => $tanggalPinjam->copy()->addDays(7),
            'status' => 'dipinjam',
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
            'denda' => $denda,
            'status' => 'dikembalikan',
        ]);

        // Tambah stok buku
        $peminjaman->book->increment('stok');

        $pesan = 'Buku berhasil dikembalikan.';
        if ($denda > 0) {
            $pesan .= ' Denda keterlambatan: Rp'.number_format($denda, 0, ',', '.');
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
