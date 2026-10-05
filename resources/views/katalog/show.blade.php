@extends('layouts.app')

@section('title', $buku->judul . ' — Lentera Pustaka')
@section('meta_description', \Illuminate\Support\Str::limit($buku->sinopsis ?: 'Detail buku ' . $buku->judul . ' karya ' . $buku->pengarang, 150))

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-0" style="font-size:0.88rem;">
            <li class="breadcrumb-item"><a href="{{ route('katalog.index') }}" class="text-hijau">Katalog</a></li>
            <li class="breadcrumb-item"><a href="{{ route('katalog.index', ['kategori' => $buku->category_id]) }}" class="text-hijau">{{ $buku->category->nama ?? '-' }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $buku->judul }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-md-4 col-lg-3">
            <div class="book-card">
                <div class="book-cover-placeholder" style="height:320px;">
                    <i class="bi bi-book" style="font-size:4rem;"></i>
                    <span>{{ $buku->category->nama ?? 'Buku' }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-lg-9">
            <div class="card-perpus">
                <div class="card-body p-4">
                    <div class="book-category" style="color:var(--emas);font-weight:600;font-size:0.8rem;text-transform:uppercase;letter-spacing:.05em;">
                        {{ $buku->category->nama ?? '-' }}
                    </div>
                    <h1 class="page-title mb-1" style="font-size:1.7rem;">{{ $buku->judul }}</h1>
                    <p class="text-lembut mb-3">oleh <strong>{{ $buku->pengarang }}</strong></p>

                    <span class="badge badge-status {{ $buku->tersedia() ? 'badge-dikembalikan' : 'badge-terlambat' }} mb-4">
                        {{ $buku->tersedia() ? 'Tersedia — stok ' . $buku->stok : 'Stok habis' }}
                    </span>

                    <dl class="row mb-4" style="font-size:0.92rem;">
                        <dt class="col-sm-4 text-lembut fw-normal">Penerbit</dt>
                        <dd class="col-sm-8">{{ $buku->penerbit }}</dd>
                        <dt class="col-sm-4 text-lembut fw-normal">Tahun Terbit</dt>
                        <dd class="col-sm-8">{{ $buku->tahun_terbit }}</dd>
                        <dt class="col-sm-4 text-lembut fw-normal">ISBN</dt>
                        <dd class="col-sm-8">{{ $buku->isbn ?? '-' }}</dd>
                        <dt class="col-sm-4 text-lembut fw-normal">Lokasi Rak</dt>
                        <dd class="col-sm-8">{{ $buku->lokasi_rak ?? '-' }}</dd>
                    </dl>

                    <h2 class="section-title" style="font-size:1.1rem;">Sinopsis</h2>
                    <p style="line-height:1.8;">{{ $buku->sinopsis ?: 'Belum ada sinopsis untuk buku ini.' }}</p>

                    <p class="text-lembut mb-0" style="font-size:0.85rem;">
                        <i class="bi bi-info-circle me-1"></i> Untuk meminjam, temui petugas perpustakaan. Lama pinjam 7 hari.
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if($terkait->count() > 0)
    <h2 class="section-title mt-5">Buku Sekategori</h2>
    <div class="row g-4">
        @foreach($terkait as $t)
        <div class="col-6 col-lg-3">
            <a href="{{ route('katalog.show', $t) }}" class="text-decoration-none">
                <div class="book-card">
                    <div class="card-body">
                        <div class="book-title">{{ $t->judul }}</div>
                        <div class="book-author mb-0"><i class="bi bi-person-fill me-1"></i> {{ $t->pengarang }}</div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
