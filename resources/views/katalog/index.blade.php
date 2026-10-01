@extends('layouts.app')

@section('title', 'Katalog Buku — Perpustakaan Sekolah')
@section('meta_description', 'Jelajahi koleksi buku perpustakaan sekolah. Cari berdasarkan judul, pengarang, atau kategori.')

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <h1 class="page-title" style="display:inline-block;">Katalog Buku</h1>
        <p class="page-subtitle">Temukan buku favoritmu dari koleksi perpustakaan</p>
    </div>

    {{-- Placeholder — halaman ini akan dilengkapi oleh Nasya --}}
    <div class="empty-state py-5">
        <i class="bi bi-book"></i>
        <h5>Katalog Sedang Disiapkan</h5>
        <p>Halaman katalog buku akan segera tersedia. Silakan kembali lagi nanti!</p>
    </div>
</div>
@endsection
