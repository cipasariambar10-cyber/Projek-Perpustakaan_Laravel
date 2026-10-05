<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $buku = Book::with('category')
            ->cari($request->input('q'))
            ->kategori($request->input('kategori'))
            ->orderBy('judul')
            ->paginate(12)
            ->withQueryString();

        $kategori = Category::orderBy('nama')->get();

        return view('katalog.index', compact('buku', 'kategori'));
    }

    public function show(Book $book)
    {
        $book->load('category');

        $terkait = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->latest()
            ->limit(4)
            ->get();

        return view('katalog.show', ['buku' => $book, 'terkait' => $terkait]);
    }
}
