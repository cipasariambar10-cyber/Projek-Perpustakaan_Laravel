@extends('layouts.app')

@section('title', $book->judul . ' — Katalog Buku')
@section('meta_description', Str::limit($book->sinopsis, 150))

@section('content')
<div class="container py-5" style="background-color: #fdfbf7; border-radius: 1rem;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('katalog.index') }}" class="text-success text-decoration-none">Katalog</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($book->judul, 30) }}</li>
        </ol>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
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
                <div class="rounded-4 d-flex align-items-center justify-content-center bg-light text-muted shadow" style="height: 400px; width: 100%; background-color: #e9ecef;">
                    <i class="bi bi-book" style="font-size: 6rem;"></i>
                </div>
            @endif
        </div>

        <!-- Detail Section -->
        <div class="col-md-8 col-lg-9">
            @if($book->category)
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill mb-3 fs-6">{{ $book->category->nama }}</span>
            @endif
            
            <h1 class="mb-2" style="font-family: 'Merriweather', serif; font-weight: 700; color: #1a4d2e;">{{ $book->judul }}</h1>
            <p class="fs-5 text-muted mb-4">{{ $book->pengarang }}</p>

            <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
                @if($book->stok > 0)
                    <span class="badge bg-success rounded-pill px-3 py-2 fs-6 shadow-sm"><i class="bi bi-check2-circle me-1"></i> Tersedia: {{ $book->stok }} Buku</span>
                @else
                    <span class="badge bg-danger rounded-pill px-3 py-2 fs-6 shadow-sm"><i class="bi bi-x-circle me-1"></i> Stok Habis</span>
                @endif
                <span class="text-muted"><i class="bi bi-upc-scan me-1"></i> ISBN: {{ $book->isbn ?? '-' }}</span>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4" style="background-color: white;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3" style="color: #1a4d2e;">Sinopsis</h5>
                    <p class="card-text text-secondary" style="line-height: 1.7;">
                        {{ $book->sinopsis ?: 'Belum ada sinopsis untuk buku ini.' }}
                    </p>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-md-3">
                    <div class="p-3 bg-white rounded-4 shadow-sm h-100 border border-light">
                        <small class="text-muted d-block mb-1">Penerbit</small>
                        <span class="fw-medium">{{ $book->penerbit ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="p-3 bg-white rounded-4 shadow-sm h-100 border border-light">
                        <small class="text-muted d-block mb-1">Tahun Terbit</small>
                        <span class="fw-medium">{{ $book->tahun_terbit ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="p-3 bg-white rounded-4 shadow-sm h-100 border border-light">
                        <small class="text-muted d-block mb-1">Jml Halaman</small>
                        <span class="fw-medium">{{ $book->jumlah_halaman ?? '-' }} hlm</span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="p-3 bg-white rounded-4 shadow-sm h-100 border border-light">
                        <small class="text-muted d-block mb-1">Lokasi Rak</small>
                        <span class="fw-medium">{{ $book->lokasi_rak ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('katalog.pinjam', $book->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success btn-lg px-5 py-3 rounded-pill fw-bold shadow-sm" style="background-color: #1a4d2e; border: none;" {{ $book->stok <= 0 ? 'disabled' : '' }}>
                    <i class="bi bi-bookmark-plus me-2"></i> Pinjam Buku Ini
                </button>
            </form>
        </div>
    </div>

    <!-- Buku Terkait Section -->
    @if($bukuTerkait->count() > 0)
        <hr class="my-5" style="border-color: #1a4d2e; opacity: 0.1;">
        <div class="mb-4 d-flex justify-content-between align-items-end flex-wrap gap-2">
            <div>
                <h3 class="fw-bold m-0" style="font-family: 'Merriweather', serif; color: #1a4d2e;">Buku Terkait</h3>
                <p class="text-muted m-0 mt-1">Koleksi lain dalam kategori yang sama</p>
            </div>
            <a href="{{ route('katalog.index', ['kategori' => $book->category_id]) }}" class="text-success text-decoration-none fw-medium">Lihat Semua <i class="bi bi-arrow-right"></i></a>
        </div>
        
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($bukuTerkait as $terkait)
                <div class="col">
                    <x-book-card :book="$terkait" />
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
