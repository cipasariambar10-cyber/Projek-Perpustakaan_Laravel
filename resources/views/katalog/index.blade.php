@extends('layouts.app')

@section('title', 'Katalog Buku — Lentera Pustaka')
@section('meta_description', 'Jelajahi koleksi buku perpustakaan. Cari berdasarkan judul, pengarang, atau kategori.')

@section('content')
<div class="container py-5" style="background-color: #fdfbf7; border-radius: 1rem; min-height: 80vh;">
    <div class="text-center mb-5">
        <h1 class="page-title" style="display:inline-block; font-family: 'Merriweather', serif; color: #1a4d2e; font-weight: 700;">Katalog Buku</h1>
        <p class="page-subtitle text-muted mt-2">Temukan buku favoritmu dari koleksi perpustakaan</p>
    </div>

    <!-- Search & Filters -->
    <form action="{{ route('katalog.index') }}" method="GET" class="mb-5">
        <div class="row g-3 justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="input-group shadow-sm rounded-3">
                    <span class="input-group-text bg-white border-end-0 text-success"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control border-start-0 ps-0" placeholder="Cari judul, penulis, atau ISBN..." value="{{ request('q') }}">
                </div>
            </div>
            <div class="col-md-3 col-lg-2">
                <select name="kategori" class="form-select shadow-sm text-secondary rounded-3" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 col-lg-2">
                <select name="tersedia" class="form-select shadow-sm text-secondary rounded-3" onchange="this.form.submit()">
                    <option value="Semua" {{ request('tersedia') == 'Semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="Tersedia" {{ request('tersedia') == 'Tersedia' ? 'selected' : '' }}>Hanya Tersedia</option>
                </select>
            </div>
            <div class="col-md-12 col-lg-2 text-center text-lg-start">
                <select name="urutan" class="form-select shadow-sm text-secondary rounded-3" onchange="this.form.submit()">
                    <option value="terbaru" {{ request('urutan') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="a-z" {{ request('urutan') == 'a-z' ? 'selected' : '' }}>Judul A-Z</option>
                    <option value="z-a" {{ request('urutan') == 'z-a' ? 'selected' : '' }}>Judul Z-A</option>
                </select>
            </div>
            <!-- Hidden submit to allow pressing Enter on text field -->
            <button type="submit" class="d-none">Cari</button>
        </div>
    </form>

    <!-- Grid Buku -->
    @if($books->count() > 0)
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($books as $book)
                <div class="col">
                    <x-book-card :book="$book" />
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5 custom-pagination">
            {{ $books->links('pagination::bootstrap-5') }}
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state py-5 text-center">
            <i class="bi bi-book text-muted mb-3" style="font-size: 5rem;"></i>
            <h5 class="fw-bold" style="color: #1a4d2e;">Buku tidak ditemukan</h5>
            <p class="text-muted mb-4">Coba sesuaikan kata kunci pencarian atau filter Anda.</p>
            <a href="{{ route('katalog.index') }}" class="btn btn-outline-success rounded-pill px-4">Reset Filter</a>
        </div>
    @endif
</div>

<style>
/* Custom Pagination Colors */
.custom-pagination .page-link {
    color: #1a4d2e;
}
.custom-pagination .page-item.active .page-link {
    background-color: #1a4d2e;
    border-color: #1a4d2e;
    color: white;
}
.custom-pagination .page-link:hover {
    background-color: #e9f0eb;
    color: #1a4d2e;
}
</style>
@endsection
