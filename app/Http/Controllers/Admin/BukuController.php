<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $buku = Book::with('category')
            ->cari($request->input('q'))
            ->kategori($request->input('kategori'))
            ->orderBy('judul')
            ->paginate(10)
            ->withQueryString();

        $kategori = Category::orderBy('nama')->get();

        return view('admin.buku.index', compact('buku', 'kategori'));
    }

    public function create()
    {
        $kategori = Category::orderBy('nama')->get();

        return view('admin.buku.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        Book::create($this->validated($request));

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $buku)
    {
        return redirect()->route('katalog.show', $buku);
    }

    public function edit(Book $buku)
    {
        $kategori = Category::orderBy('nama')->get();

        return view('admin.buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, Book $buku)
    {
        $buku->update($this->validated($request, $buku));

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $buku)
    {
        // Cegah hapus jika masih ada peminjaman terkait (tabel loans milik Hayfa).
        if (\Illuminate\Support\Facades\Schema::hasTable('loans')
            && \Illuminate\Support\Facades\DB::table('loans')->where('book_id', $buku->id)->exists()) {
            return redirect()->route('admin.buku.index')
                ->with('error', "Buku \"{$buku->judul}\" memiliki riwayat peminjaman dan tidak bisa dihapus.");
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');
    }

    private function validated(Request $request, ?Book $buku = null): array
    {
        return $request->validate([
            'category_id'  => ['required', 'exists:categories,id'],
            'judul'        => ['required', 'string', 'max:255'],
            'pengarang'    => ['required', 'string', 'max:255'],
            'penerbit'     => ['required', 'string', 'max:255'],
            'tahun_terbit' => ['required', 'integer', 'min:1000', 'max:' . date('Y')],
            'isbn'         => ['nullable', 'string', 'max:20', Rule::unique('books', 'isbn')->ignore($buku?->id)],
            'stok'         => ['required', 'integer', 'min:0'],
            'lokasi_rak'   => ['nullable', 'string', 'max:50'],
            'sinopsis'     => ['nullable', 'string'],
        ]);
    }
}
