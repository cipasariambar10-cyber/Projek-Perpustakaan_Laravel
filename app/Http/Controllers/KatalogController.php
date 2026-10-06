<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $kategoriList = Category::orderBy('nama', 'asc')->get();
        
        $booksQuery = Book::with('category')
            ->search($request->q)
            ->kategori($request->kategori)
            ->tersedia($request->tersedia);

        // Sorting
        if ($request->urutan == 'z-a') {
            $booksQuery->orderBy('judul', 'desc');
        } elseif ($request->urutan == 'a-z') {
            $booksQuery->orderBy('judul', 'asc');
        } else {
            $booksQuery->orderBy('created_at', 'desc'); // default Terbaru
        }

        $books = $booksQuery->paginate(12)->withQueryString();

        return view('katalog.index', compact('books', 'kategoriList'));
    }

    public function show(Book $book)
    {
        $book->load('category');
        $bukuTerkait = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('katalog.show', compact('book', 'bukuTerkait'));
    }

    public function pinjam(Request $request, Book $book)
    {
        $user = auth()->user();

        // Cek jika belum login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk meminjam buku.');
        }

        // Cek apakah user sudah meminjam buku ini dan belum dikembalikan
        $alreadyBorrowed = Loan::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($alreadyBorrowed) {
            return back()->with('error', 'Anda sudah meminjam buku ini dan belum mengembalikannya.');
        }

        if ($book->stok <= 0) {
            return back()->with('error', 'Mohon maaf, stok buku sedang habis.');
        }

        try {
            DB::transaction(function () use ($book, $user) {
                // Lock the row for update to prevent race conditions
                $lockedBook = Book::where('id', $book->id)->lockForUpdate()->first();

                if ($lockedBook->stok <= 0) {
                    throw new \Exception('Stok habis');
                }

                $lockedBook->decrement('stok');

                Loan::create([
                    'user_id' => $user->id,
                    'book_id' => $lockedBook->id,
                    'tanggal_pinjam' => now()->toDateString(),
                    'batas_kembali' => now()->addDays(7)->toDateString(),
                    'status' => 'dipinjam',
                ]);
            });

            return redirect()->route('anggota.peminjaman')->with('success', 'Buku berhasil dipinjam! Silakan ambil di perpustakaan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal meminjam buku. Silakan coba lagi. Error: ' . $e->getMessage());
        }
    }
}
