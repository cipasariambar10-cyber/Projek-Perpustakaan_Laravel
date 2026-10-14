@extends('layouts.app')

@section('title', 'Riwayat Peminjaman Saya — Lentera Pustaka')

@section('content')
    <div class="container py-4">
        <div class="mb-4">
            <h1 class="page-title">Peminjaman Saya</h1>
            <p class="page-subtitle mb-0">Riwayat peminjaman dan pengembalian buku Anda</p>
        </div>

        {{-- Filter --}}
        <div class="card-perpus mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('anggota.peminjaman') }}" class="row g-3 align-items-end form-perpus">
                    <div class="col-md-4">
                        <label class="form-label"><i class="bi bi-funnel me-1"></i> Filter Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua</option>
                            <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-hijau flex-fill">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                        @if(request()->hasAny(['status']))
                        <a href="{{ route('anggota.peminjaman') }}" class="btn btn-outline-hijau">
                            <i class="bi bi-x-lg"></i>
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Daftar Peminjaman --}}
        @if($peminjaman->count() > 0)
            {{-- Tampilan kartu untuk mobile-friendly --}}
            <div class="row g-3">
                @foreach($peminjaman as $loan)
                <div class="col-12">
                    <div class="card-perpus">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                <div class="d-flex gap-3 flex-grow-1 align-items-center">
                                    {{-- Sampul Buku --}}
                                    <div class="flex-shrink-0">
                                        @if(!empty($loan->book?->sampul))
                                            <a href="{{ route('katalog.show', $loan->book->id) }}" class="d-block text-decoration-none">
                                                <img src="{{ asset('storage/' . $loan->book->sampul) }}"
                                                     alt="Cover {{ $loan->book->judul }}"
                                                     class="rounded-3 shadow-sm"
                                                     style="width: 65px; height: 95px; object-fit: cover; object-position: center top; border: 1px solid var(--cream-200); transition: transform 0.2s ease, box-shadow 0.2s ease;"
                                                     onmouseover="this.style.transform='scale(1.04)'; this.style.boxShadow='var(--shadow-md)';"
                                                     onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='var(--shadow-sm)';">
                                            </a>
                                        @else
                                            <div class="d-flex flex-column align-items-center justify-content-center rounded-3 shadow-sm text-center"
                                                 style="width: 65px; height: 95px; background: var(--gradient-green); color: var(--cream-50); border: 1px solid var(--cream-200);">
                                                <i class="bi bi-book" style="font-size: 1.5rem; margin-bottom: 2px;"></i>
                                                <span style="font-size: 0.65rem; opacity: 0.85;">Tanpa Sampul</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-grow-1">
                                        @if($loan->book?->category)
                                            <span class="badge px-2 py-1 rounded-pill mb-1" style="background: rgba(212, 162, 76, 0.15); color: var(--gold-800); font-size: 0.72rem; border: 1px solid rgba(212, 162, 76, 0.3);">
                                                {{ $loan->book->category->nama }}
                                            </span>
                                        @endif
                                        <h6 class="mb-1" style="font-family: var(--font-judul); font-size: 1.05rem; font-weight: 700;">
                                            @if($loan->book)
                                                <a href="{{ route('katalog.show', $loan->book->id) }}" class="text-decoration-none text-reset" style="color: var(--green-900);">
                                                    {{ $loan->book->judul }}
                                                </a>
                                            @else
                                                Buku tidak ditemukan
                                            @endif
                                        </h6>
                                        <div style="font-size:0.85rem; color: var(--teks-lembut); margin-bottom:0.5rem;">
                                            <i class="bi bi-person-fill me-1"></i>{{ $loan->book->pengarang ?? '-' }}
                                        </div>
                                        <div class="d-flex flex-wrap gap-3" style="font-size:0.82rem; color: var(--teks-lembut);">
                                            <span>
                                                <i class="bi bi-calendar-event me-1"></i>
                                                Pinjam: <strong>{{ $loan->tanggal_pinjam->format('d/m/Y') }}</strong>
                                            </span>
                                            <span>
                                                <i class="bi bi-calendar-check me-1"></i>
                                                Batas: <strong style="{{ $loan->isTerlambat() ? 'color: var(--status-terlambat);' : '' }}">{{ $loan->batas_kembali->format('d/m/Y') }}</strong>
                                            </span>
                                            @if($loan->tanggal_kembali)
                                            <span>
                                                <i class="bi bi-calendar2-check me-1"></i>
                                                Kembali: <strong>{{ $loan->tanggal_kembali->format('d/m/Y') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end d-flex flex-column align-items-end justify-content-center">
                                    @if($loan->status === 'dipinjam' && $loan->isTerlambat())
                                        <span class="badge badge-status badge-terlambat">
                                            <i class="bi bi-exclamation-triangle me-1"></i> Terlambat
                                        </span>
                                        <div style="font-size:0.78rem; color: var(--status-terlambat); margin-top:0.35rem; font-weight:600;">
                                            {{ $loan->hariTerlambat() }} hari — Rp{{ number_format($loan->hitungDenda(), 0, ',', '.') }}
                                        </div>
                                    @elseif($loan->status === 'dipinjam')
                                        <span class="badge badge-status badge-dipinjam">Dipinjam</span>
                                    @else
                                        <span class="badge badge-status badge-dikembalikan">Dikembalikan</span>
                                        @if($loan->denda > 0)
                                            <div style="font-size:0.78rem; color: var(--status-terlambat); margin-top:0.35rem; font-weight:600;">
                                                Denda: Rp{{ number_format($loan->denda, 0, ',', '.') }}
                                            </div>
                                        @endif
                                    @endif

                                    @if($loan->book)
                                    <div class="mt-2">
                                        <a href="{{ route('katalog.show', $loan->book->id) }}" class="btn btn-sm btn-outline-hijau rounded-pill py-1 px-3" style="font-size: 0.78rem;">
                                            <i class="bi bi-eye me-1"></i> Detail Buku
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($peminjaman->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $peminjaman->links() }}
            </div>
            @endif

        @else
            <div class="card-perpus">
                <div class="card-body">
                    <div class="empty-state py-5">
                        <i class="bi bi-journal-bookmark" style="font-size:3rem;"></i>
                        <p class="mb-1 fw-semibold">Belum ada riwayat peminjaman</p>
                        <p class="mb-3" style="font-size:0.85rem;">Anda belum pernah meminjam buku dari perpustakaan.</p>

                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
