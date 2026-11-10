@extends('layouts.app')

@section('title', 'Katalog Buku — Lentera Pustaka')
@section('meta_description', 'Jelajahi koleksi buku perpustakaan. Cari berdasarkan judul, pengarang, atau kategori.')

@section('content')
{{-- ===== BANNER HEADER LUXURY KATALOG ===== --}}
<section class="page-luxury-banner">
    <div class="hero-blobs" aria-hidden="true">
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <div class="hero-blob hero-blob-3"></div>
    </div>
    <div class="hero-geom-shapes" aria-hidden="true">
        <div class="geom-ring geom-ring-1"></div>
        <div class="geom-ring geom-ring-2"></div>
    </div>
    <div class="hero-rays" aria-hidden="true">
        <div class="hero-ray hero-ray-1"></div>
        <div class="hero-ray hero-ray-2"></div>
    </div>
    <div class="hero-noise" aria-hidden="true"></div>

    <div class="container position-relative text-center" style="z-index: 5;">
        <div class="hero-badge-wrapper mb-2">
            <span class="hero-badge">
                <span class="hero-badge-dot"></span>
                Eksplorasi Koleksi Digital
            </span>
        </div>
        <h1 class="page-banner-title mb-2">
            Katalog <span class="hero-accent-shimmer">Lentera Pustaka</span>
        </h1>
        <p class="page-banner-subtitle mx-auto mb-3">
            Temukan buku favoritmu dari ratusan literatur pilihan, referensi akademik, hingga karya sastra terbaik.
        </p>

        {{-- Pill Ringkasan Koleksi --}}
        <div class="d-flex justify-content-center flex-wrap gap-2">
            <span class="banner-meta-pill">
                <i class="bi bi-journal-check"></i>
                <span><strong>{{ $books->total() }}</strong> Judul Tersedia</span>
            </span>
            <span class="banner-meta-pill">
                <i class="bi bi-tags-fill"></i>
                <span><strong>{{ $kategoriList->count() }}</strong> Kategori Buku</span>
            </span>
            <span class="banner-meta-pill">
                <i class="bi bi-lightning-charge-fill"></i>
                <span>Sirkulasi Digital</span>
            </span>
        </div>
    </div>
</section>

{{-- ===== AREA KONTEN KATALOG DENGAN ANIMASI LATAR ===== --}}
<section class="section-buku-terbaru position-relative" style="min-height: 75vh;">
    {{-- Aurora Mesh, Mandala Berputar, & Bintang Emas Melayang --}}
    <div class="section-glow-orbs" aria-hidden="true">
        <div class="section-glow-1"></div>
        <div class="section-glow-2"></div>
        <div class="section-decor-ring section-ring-left"></div>
        <div class="section-decor-ring section-ring-right"></div>
    </div>
    <div class="section-ambient-particles" aria-hidden="true"></div>

    <div class="container py-4 pb-5 position-relative" style="z-index: 2;">
        {{-- Filter & Search Bar Rapi --}}
        <div class="katalog-filter-dock mb-4">
            <form action="{{ route('katalog.index') }}" method="GET" class="form-perpus">
                <div class="row g-2 g-lg-3 align-items-center">
                    {{-- Pencarian Kata Kunci --}}
                    <div class="col-12 col-lg-5">
                        <div class="filter-input-box">
                            <i class="bi bi-search filter-box-icon"></i>
                            <input type="text" name="q" class="form-control border-0 shadow-none bg-transparent" placeholder="Cari judul buku, penulis, atau nomor ISBN..." value="{{ request('q') }}">
                            @if(request('q'))
                                <a href="{{ route('katalog.index', request()->except('q', 'page')) }}" class="filter-clear-btn" title="Hapus pencarian">
                                    <i class="bi bi-x-circle-fill"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Dropdown Kategori --}}
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="filter-select-box">
                            <i class="bi bi-grid-1x2-fill filter-box-icon"></i>
                            <select name="kategori" class="form-select border-0 shadow-none bg-transparent" onchange="this.form.submit()">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoriList as $kat)
                                    <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Dropdown Status Stok --}}
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="filter-select-box">
                            <i class="bi bi-check2-circle filter-box-icon"></i>
                            <select name="tersedia" class="form-select border-0 shadow-none bg-transparent" onchange="this.form.submit()">
                                <option value="Semua" {{ request('tersedia') == 'Semua' ? 'selected' : '' }}>Semua Stok</option>
                                <option value="Tersedia" {{ request('tersedia') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            </select>
                        </div>
                    </div>

                    {{-- Dropdown Urutan --}}
                    <div class="col-12 col-md-4 col-lg-2">
                        <div class="filter-select-box">
                            <i class="bi bi-sort-down filter-box-icon"></i>
                            <select name="urutan" class="form-select border-0 shadow-none bg-transparent" onchange="this.form.submit()">
                                <option value="terbaru" {{ request('urutan') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="a-z" {{ request('urutan') == 'a-z' ? 'selected' : '' }}>Judul A–Z</option>
                                <option value="z-a" {{ request('urutan') == 'z-a' ? 'selected' : '' }}>Judul Z–A</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="d-none">Cari</button>
                </div>
            </form>
        </div>

        {{-- Baris Info Hasil & Reset Filter --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4 px-1">
            <div class="katalog-result-text">
                <i class="bi bi-book-half me-2" style="color: var(--gold-600);"></i>
                <span>Menampilkan <strong>{{ $books->count() }}</strong> dari <strong>{{ $books->total() }}</strong> koleksi buku</span>
            </div>

            @if(request()->hasAny(['q', 'kategori', 'tersedia', 'urutan']) && (request('q') || request('kategori') || (request('tersedia') && request('tersedia') !== 'Semua') || (request('urutan') && request('urutan') !== 'terbaru')))
                <a href="{{ route('katalog.index') }}" class="btn-reset-katalog">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    <span>Reset Filter</span>
                </a>
            @endif
        </div>

        {{-- Grid Buku --}}
        @if($books->count() > 0)
            <div class="katalog-grid">
                @foreach($books as $book)
                    <x-book-card :book="$book" />
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-5 custom-pagination">
                {{ $books->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="empty-state-luxury text-center py-5 my-3">
                <div class="empty-luxury-icon mx-auto mb-3">
                    <i class="bi bi-journal-x"></i>
                </div>
                <h5 class="fw-bold mb-2" style="font-family: var(--font-judul); color: var(--green-900);">Koleksi Tidak Ditemukan</h5>
                <p class="mb-4 mx-auto" style="color: var(--teks-lembut); max-width: 420px;">
                    Maaf, kami tidak menemukan buku yang cocok dengan kata kunci atau filter yang Anda pilih.
                </p>
                <a href="{{ route('katalog.index') }}" class="btn btn-emas rounded-pill px-4 py-2">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Tampilkan Semua Buku
                </a>
            </div>
        @endif
    </div>
</section>
@endsection
