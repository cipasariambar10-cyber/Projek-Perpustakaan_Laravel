@extends('layouts.app')

@section('title', $book->judul . ' — Katalog Buku')
@section('meta_description', Str::limit($book->sinopsis, 150))

@section('content')
<div class="container py-5 my-4" style="background: var(--cream-50); border: 1px solid var(--cream-200); border-radius: var(--radius-xl); box-shadow: var(--shadow-card);">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('katalog.index') }}" class="fw-medium text-decoration-none" style="color: var(--green-700);">Katalog</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($book->judul, 30) }}</li>
        </ol>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-perpus alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-perpus alert-danger alert-dismissible fade show rounded-4 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-5 mb-5">
        <!-- Cover Section -->
        <div class="col-md-4 col-lg-3 text-center">
            @if($book->sampul)
                <img src="{{ asset('storage/' . $book->sampul) }}" class="img-fluid rounded-4 shadow" alt="Cover {{ $book->judul }}">
            @else
                <div class="rounded-4 book-cover-placeholder shadow" style="height: 400px; width: 100%;">
                    <i class="bi bi-book" style="font-size: 5rem;"></i>
                    <span style="font-size: 1rem;">Tanpa Sampul</span>
                </div>
            @endif
        </div>

        <!-- Detail Section -->
        <div class="col-md-8 col-lg-9">
            @if($book->category)
                <span class="badge px-3 py-2 rounded-pill mb-3 fs-6" style="background: rgba(212, 162, 76, 0.15); color: var(--gold-800); border: 1px solid rgba(212, 162, 76, 0.3);">{{ $book->category->nama }}</span>
            @endif
            
            <h1 class="mb-2" style="font-family: var(--font-judul); font-weight: 700; color: var(--green-900);">{{ $book->judul }}</h1>
            <p class="fs-5 mb-4" style="color: var(--teks-lembut);">{{ $book->pengarang }}</p>

            <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
                @if($book->stok > 0)
                    <span class="badge badge-status badge-tersedia px-3 py-2 fs-6 shadow-sm"><i class="bi bi-check2-circle me-1"></i> Tersedia: {{ $book->stok }} Buku</span>
                @else
                    <span class="badge badge-status badge-terlambat px-3 py-2 fs-6 shadow-sm"><i class="bi bi-x-circle me-1"></i> Stok Habis</span>
                @endif
                <span style="color: var(--teks-muted);"><i class="bi bi-upc-scan me-1"></i> ISBN: {{ $book->isbn ?? '-' }}</span>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4" style="background-color: var(--putih); border: 1px solid var(--cream-200) !important;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3" style="color: var(--green-900);">Sinopsis</h5>
                    <p class="card-text" style="color: var(--teks-lembut); line-height: 1.8;">
                        {{ $book->sinopsis ?: 'Belum ada sinopsis untuk buku ini.' }}
                    </p>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-md-3">
                    <div class="p-3 bg-white rounded-4 shadow-sm h-100" style="border: 1px solid var(--cream-200);">
                        <small class="d-block mb-1" style="color: var(--teks-muted);">Penerbit</small>
                        <span class="fw-semibold" style="color: var(--green-900);">{{ $book->penerbit ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="p-3 bg-white rounded-4 shadow-sm h-100" style="border: 1px solid var(--cream-200);">
                        <small class="d-block mb-1" style="color: var(--teks-muted);">Tahun Terbit</small>
                        <span class="fw-semibold" style="color: var(--green-900);">{{ $book->tahun_terbit ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="p-3 bg-white rounded-4 shadow-sm h-100" style="border: 1px solid var(--cream-200);">
                        <small class="d-block mb-1" style="color: var(--teks-muted);">Jml Halaman</small>
                        <span class="fw-semibold" style="color: var(--green-900);">{{ $book->jumlah_halaman ?? '-' }} hlm</span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="p-3 bg-white rounded-4 shadow-sm h-100" style="border: 1px solid var(--cream-200);">
                        <small class="d-block mb-1" style="color: var(--teks-muted);">Lokasi Rak</small>
                        <span class="fw-semibold" style="color: var(--green-900);">{{ $book->lokasi_rak ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('katalog.pinjam', $book->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-emas btn-lg px-5 py-3 rounded-pill fw-bold" {{ $book->stok <= 0 ? 'disabled' : '' }}>
                    <i class="bi bi-bookmark-plus me-2"></i> Pinjam Buku Ini
                </button>
            </form>
        </div>
    </div>

    <!-- Buku Terkait Section -->
    @if($bukuTerkait->count() > 0)
        <hr class="my-5" style="border-color: var(--cream-300);">
        <div class="mb-4 d-flex justify-content-between align-items-end flex-wrap gap-2">
            <div>
                <h3 class="fw-bold m-0" style="font-family: var(--font-judul); color: var(--green-900);">Buku Terkait</h3>
                <p class="m-0 mt-1" style="color: var(--teks-lembut);">Koleksi lain dalam kategori yang sama</p>
            </div>
            <a href="{{ route('katalog.index', ['kategori' => $book->category_id]) }}" class="fw-medium text-decoration-none" style="color: var(--green-700);">Lihat Semua <i class="bi bi-arrow-right"></i></a>
        </div>
        
        <div class="katalog-grid">
            @foreach($bukuTerkait as $terkait)
                <x-book-card :book="$terkait" />
            @endforeach
        </div>
    @endif
</div>
@endsection
