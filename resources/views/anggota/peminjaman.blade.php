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
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                <div class="d-flex gap-3 flex-grow-1">
                                    {{-- Ikon Buku --}}
                                    <div class="d-flex align-items-center justify-content-center rounded"
                                         style="width:56px;height:56px;background:linear-gradient(135deg, var(--hijau-tua), var(--hijau-tua-light));color:var(--putih);font-size:1.3rem;flex-shrink:0;border-radius: var(--radius-sm);">
                                        <i class="bi bi-book"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1" style="font-family: var(--font-judul); font-size:1rem; font-weight:700;">
                                            {{ $loan->book->judul ?? 'Buku tidak ditemukan' }}
                                        </h6>
                                        <div style="font-size:0.85rem; color: var(--teks-lembut); margin-bottom:0.5rem;">
                                            {{ $loan->book->pengarang ?? '' }}
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
                                <div class="text-end">
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
