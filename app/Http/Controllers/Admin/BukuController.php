<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $buku = Book::with('category')
            ->cari($request->input('q'))
            ->kategori($request->input('kategori'))
            ->orderBy('judul')
            ->paginate(6)
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
        $data = $this->validated($request);

        if ($request->hasFile('sampul')) {
            $data['sampul'] = $request->file('sampul')->store('covers', 'public');
        }

        Book::create($data);

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
        $data = $this->validated($request, $buku);

        if ($request->hasFile('sampul')) {
            if (! empty($buku->sampul) && Storage::disk('public')->exists($buku->sampul)) {
                Storage::disk('public')->delete($buku->sampul);
            }
            $data['sampul'] = $request->file('sampul')->store('covers', 'public');
        } else {
            unset($data['sampul']);
        }

        $buku->update($data);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $buku)
    {
        // Cegah hapus jika masih ada peminjaman terkait (tabel loans milik Hayfa).
        if (Schema::hasTable('loans')
            && DB::table('loans')->where('book_id', $buku->id)->exists()) {
            return redirect()->route('admin.buku.index')
                ->with('error', "Buku \"{$buku->judul}\" memiliki riwayat peminjaman dan tidak bisa dihapus.");
        }

        if (! empty($buku->sampul) && Storage::disk('public')->exists($buku->sampul)) {
            Storage::disk('public')->delete($buku->sampul);
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');
    }

    private function validated(Request $request, ?Book $buku = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'judul' => ['required', 'string', 'max:255'],
            'pengarang' => ['required', 'string', 'max:255'],
            'penerbit' => ['required', 'string', 'max:255'],
            'tahun_terbit' => ['required', 'integer', 'min:1000', 'max:'.date('Y')],
            'isbn' => ['nullable', 'string', 'max:20', Rule::unique('books', 'isbn')->ignore($buku?->id)],
            'jumlah_halaman' => ['nullable', 'integer', 'min:1'],
            'stok' => ['required', 'integer', 'min:0'],
            'lokasi_rak' => ['nullable', 'string', 'max:50'],
            'sampul' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'sinopsis' => ['nullable', 'string'],
        ]);
    }
}
