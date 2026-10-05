@extends('layouts.app')

@section('title', 'Katalog Buku — Lentera Pustaka')
@section('meta_description', 'Jelajahi koleksi buku perpustakaan sekolah. Cari berdasarkan judul, pengarang, atau kategori.')

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <h1 class="page-title" style="display:inline-block;">Katalog Buku</h1>
        <p class="page-subtitle">Temukan buku favoritmu dari koleksi perpustakaan</p>
    </div>

    {{-- Pencarian & filter kategori --}}
    <div class="card-perpus mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('katalog.index') }}" class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label for="q" class="visually-hidden">Cari</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background:var(--putih);border-color:var(--garis-tebal);">
                            <i class="bi bi-search" style="color:var(--teks-muted);"></i>
                        </span>
                        <input type="text" id="q" name="q" class="form-control" placeholder="Cari judul atau pengarang..."
                               value="{{ request('q') }}" style="border-color:var(--garis-tebal);">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="kategori" class="visually-hidden">Kategori</label>
                    <select id="kategori" name="kategori" class="form-select" style="border-color:var(--garis-tebal);">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" @selected(request('kategori') == $k->id)>{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-hijau flex-fill"><i class="bi bi-search me-1"></i> Cari</button>
                    <a href="{{ route('katalog.index') }}" class="btn btn-outline-hijau" title="Reset"><i class="bi bi-x-lg"></i></a>
                </div>
            </form>
        </div>
    </div>

    @if($buku->count() > 0)
    <p class="text-lembut" style="font-size:0.85rem;">Menampilkan {{ $buku->total() }} buku</p>
    <div class="row g-4">
        @foreach($buku as $b)
        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('katalog.show', $b) }}" class="text-decoration-none">
                <div class="book-card">
                    <div class="book-cover-placeholder">
                        <i class="bi bi-book"></i>
                        <span>{{ $b->category->nama ?? 'Buku' }}</span>
                    </div>
                    <div class="card-body">
                        <div class="book-category">{{ $b->category->nama ?? '-' }}</div>
                        <div class="book-title">{{ $b->judul }}</div>
                        <div class="book-author"><i class="bi bi-person-fill me-1"></i> {{ $b->pengarang }}</div>
                        <div class="book-meta">
                            <span><i class="bi bi-calendar3 me-1"></i> {{ $b->tahun_terbit }}</span>
                            <span class="badge badge-status {{ $b->tersedia() ? 'badge-dikembalikan' : 'badge-terlambat' }}">
                                {{ $b->tersedia() ? 'Tersedia: ' . $b->stok : 'Habis' }}
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    @if($buku->hasPages())
    <div class="d-flex justify-content-center mt-4">{{ $buku->links() }}</div>
    @endif
    @else
    <div class="empty-state py-5">
        <i class="bi bi-book"></i>
        <h5>Buku Tidak Ditemukan</h5>
        <p>Coba kata kunci atau kategori lain. <a href="{{ route('katalog.index') }}">Tampilkan semua buku</a></p>
    </div>
    @endif
</div>
@endsection
