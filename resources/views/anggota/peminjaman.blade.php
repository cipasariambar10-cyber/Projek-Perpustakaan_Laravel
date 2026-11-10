@extends('layouts.app')

@section('title', 'Riwayat Peminjaman Saya — Lentera Pustaka')

@section('content')
{{-- ===== BANNER HEADER LUXURY PEMINJAMAN SAYA ===== --}}
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
                Sirkulasi & Jejak Literasi Anggota
            </span>
        </div>
        <h1 class="page-banner-title mb-2">
            Peminjaman <span class="hero-accent-shimmer">Saya</span>
        </h1>
        <p class="page-banner-subtitle mx-auto mb-0">
            Pantau buku yang sedang Anda pinjam, batas pengembalian, serta seluruh riwayat bacaan Anda di Lentera Pustaka.
        </p>
    </div>
</section>

{{-- ===== AREA KONTEN PEMINJAMAN DENGAN ANIMASI LATAR ===== --}}
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
        {{-- 4 Kartu Ringkasan Sirkulasi Anggota --}}
        <div class="peminjaman-stats-dock mb-4">
            <div class="row g-3">
                <div class="col-6 col-lg-3">
                    <div class="peminjaman-stat-card">
                        <div class="pstat-icon pstat-green">
                            <i class="bi bi-journals"></i>
                        </div>
                        <div class="pstat-info">
                            <span class="pstat-value">{{ $stats['total'] ?? $peminjaman->total() }}</span>
                            <span class="pstat-label">Total Riwayat</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="peminjaman-stat-card">
                        <div class="pstat-icon pstat-gold">
                            <i class="bi bi-book-half"></i>
                        </div>
                        <div class="pstat-info">
                            <span class="pstat-value">{{ $stats['dipinjam'] ?? 0 }}</span>
                            <span class="pstat-label">Sedang Dipinjam</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="peminjaman-stat-card">
                        <div class="pstat-icon pstat-teal">
                            <i class="bi bi-check2-all"></i>
                        </div>
                        <div class="pstat-info">
                            <span class="pstat-value">{{ $stats['dikembalikan'] ?? 0 }}</span>
                            <span class="pstat-label">Sudah Kembali</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="peminjaman-stat-card">
                        <div class="pstat-icon pstat-red">
                            <i class="bi bi-exclamation-octagon"></i>
                        </div>
                        <div class="pstat-info">
                            <span class="pstat-value">{{ $stats['terlambat'] ?? 0 }}</span>
                            <span class="pstat-label">Perlu Perhatian</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bar Navigasi Filter Pill & Shortcut Katalog --}}
        <div class="peminjaman-toolbar d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div class="peminjaman-filter-dock">
                <a href="{{ route('anggota.peminjaman') }}"
                   class="cat-chip {{ !request('status') ? 'active' : '' }}">
                    <i class="bi bi-collection"></i>
                    <span>Semua ({{ $stats['total'] ?? 0 }})</span>
                </a>
                <a href="{{ route('anggota.peminjaman', ['status' => 'dipinjam']) }}"
                   class="cat-chip {{ request('status') === 'dipinjam' ? 'active' : '' }}">
                    <i class="bi bi-hourglass-split"></i>
                    <span>Dipinjam ({{ $stats['dipinjam'] ?? 0 }})</span>
                </a>
                <a href="{{ route('anggota.peminjaman', ['status' => 'dikembalikan']) }}"
                   class="cat-chip {{ request('status') === 'dikembalikan' ? 'active' : '' }}">
                    <i class="bi bi-check-circle"></i>
                    <span>Dikembalikan ({{ $stats['dikembalikan'] ?? 0 }})</span>
                </a>
                <a href="{{ route('anggota.peminjaman', ['status' => 'terlambat']) }}"
                   class="cat-chip {{ request('status') === 'terlambat' ? 'active' : '' }}">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>Terlambat ({{ $stats['terlambat'] ?? 0 }})</span>
                </a>
            </div>

            <a href="{{ route('katalog.index') }}" class="btn-book-action btn-book-pinjam px-3 flex-shrink-0" style="height: 38px;">
                <i class="bi bi-compass"></i>
                <span>Pinjam Buku Baru</span>
            </a>
        </div>

        {{-- Daftar Kartu Peminjaman Luxury --}}
        @if($peminjaman->count() > 0)
            <div class="row g-3">
                @foreach($peminjaman as $loan)
                <div class="col-12">
                    <div class="loan-luxury-card">
                        <div class="loan-card-accent {{ ($loan->status === 'dipinjam' && $loan->isTerlambat()) ? 'accent-danger' : ($loan->status === 'dipinjam' ? 'accent-gold' : 'accent-green') }}"></div>

                        <div class="loan-card-inner d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                            {{-- Kiri: Sampul 3D + Informasi Buku + Timeline Tanggal --}}
                            <div class="d-flex gap-3 align-items-center flex-grow-1">
                                <div class="loan-cover-thumb flex-shrink-0">
                                    @if(!empty($loan->book?->sampul))
                                        <a href="{{ route('katalog.show', $loan->book->id) }}" class="d-block text-decoration-none position-relative">
                                            <img src="{{ asset('storage/' . $loan->book->sampul) }}" alt="Cover {{ $loan->book->judul }}">
                                        </a>
                                    @else
                                        <div class="loan-cover-placeholder">
                                            <i class="bi bi-book"></i>
                                            <span>No Cover</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-grow-1 min-w-0">
                                    <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                                        @if($loan->book?->category)
                                            <span class="book-category-pill">{{ $loan->book->category->nama }}</span>
                                        @endif
                                        <span class="loan-id-tag">#PINJAM-{{ str_pad($loan->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </div>

                                    <h5 class="loan-book-title mb-1">
                                        @if($loan->book)
                                            <a href="{{ route('katalog.show', $loan->book->id) }}" class="text-decoration-none">
                                                {{ $loan->book->judul }}
                                            </a>
                                        @else
                                            Buku Tidak Ditemukan
                                        @endif
                                    </h5>

                                    <div class="loan-book-author mb-2">
                                        <i class="bi bi-feather me-1" style="color: var(--gold-600);"></i>{{ $loan->book->pengarang ?? '-' }}
                                    </div>

                                    {{-- Kapsul Timeline Tanggal --}}
                                    <div class="loan-timeline-pills">
                                        <span class="timeline-pill">
                                            <i class="bi bi-calendar-plus text-success"></i>
                                            <span>Pinjam: <strong>{{ $loan->tanggal_pinjam->format('d M Y') }}</strong></span>
                                        </span>
                                        <span class="timeline-pill {{ $loan->isTerlambat() && $loan->status === 'dipinjam' ? 'timeline-overdue' : '' }}">
                                            <i class="bi bi-calendar-event" style="color: var(--gold-600);"></i>
                                            <span>Tenggat: <strong>{{ $loan->batas_kembali->format('d M Y') }}</strong></span>
                                        </span>
                                        @if($loan->tanggal_kembali)
                                        <span class="timeline-pill timeline-returned">
                                            <i class="bi bi-calendar2-check-fill"></i>
                                            <span>Kembali: <strong>{{ $loan->tanggal_kembali->format('d M Y') }}</strong></span>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Kanan: Status Badge, Denda, & Tombol Detail Sejajar Rapi --}}
                            <div class="loan-card-right d-flex flex-wrap flex-lg-nowrap align-items-center justify-content-between justify-content-lg-end gap-3 pt-2 pt-lg-0">
                                <div class="d-flex flex-column align-items-start align-items-lg-end gap-1">
                                    @if($loan->status === 'dipinjam' && $loan->isTerlambat())
                                        <span class="badge badge-status badge-terlambat px-3 py-1">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Terlambat {{ $loan->hariTerlambat() }} Hari
                                        </span>
                                        <span class="loan-fine-pill">
                                            Estimasi Denda: <strong>Rp{{ number_format($loan->hitungDenda(), 0, ',', '.') }}</strong>
                                        </span>
                                    @elseif($loan->status === 'dipinjam')
                                        <span class="badge badge-status badge-dipinjam px-3 py-1">
                                            <i class="bi bi-clock-history me-1"></i> Sedang Dipinjam
                                        </span>
                                    @else
                                        <span class="badge badge-status badge-dikembalikan px-3 py-1">
                                            <i class="bi bi-check-circle-fill me-1"></i> Sudah Dikembalikan
                                        </span>
                                        @if($loan->denda > 0)
                                            <span class="loan-fine-pill">
                                                Denda Tercatat: <strong>Rp{{ number_format($loan->denda, 0, ',', '.') }}</strong>
                                            </span>
                                        @endif
                                    @endif
                                </div>

                                @if($loan->book)
                                    <a href="{{ route('katalog.show', $loan->book->id) }}" class="btn-book-action btn-book-detail px-3 flex-shrink-0" style="height: 38px;">
                                        <i class="bi bi-book-half"></i>
                                        <span>Lihat Buku</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($peminjaman->hasPages())
            <div class="d-flex justify-content-center mt-4 custom-pagination">
                {{ $peminjaman->links('pagination::bootstrap-5') }}
            </div>
            @endif

        @else
            <div class="empty-state-luxury text-center py-5 my-3">
                <div class="empty-luxury-icon mx-auto mb-3">
                    <i class="bi bi-journal-bookmark"></i>
                </div>
                <h5 class="fw-bold mb-2" style="font-family: var(--font-judul); color: var(--green-900);">Belum Ada Riwayat Peminjaman</h5>
                <p class="mb-4 mx-auto" style="color: var(--teks-lembut); max-width: 440px;">
                    @if(request('status'))
                        Tidak ada data peminjaman dengan status <strong>{{ ucfirst(request('status')) }}</strong> saat ini.
                    @else
                        Anda belum memiliki riwayat peminjaman buku. Yuk, jelajahi katalog dan mulai petualangan literasi Anda!
                    @endif
                </p>
                <div class="d-flex justify-content-center gap-2">
                    @if(request('status'))
                        <a href="{{ route('anggota.peminjaman') }}" class="btn btn-outline-hijau rounded-pill px-4">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Lihat Semua Riwayat
                        </a>
                    @endif
                    <a href="{{ route('katalog.index') }}" class="btn btn-emas rounded-pill px-4">
                        <i class="bi bi-compass me-1"></i> Jelajahi Katalog Buku
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
