@extends('layouts.admin')

@section('title', 'Detail Peminjaman — Perpustakaan')

@section('content')
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" style="font-size:0.85rem;">
                        <li class="breadcrumb-item"><a href="{{ route('admin.peminjaman.index') }}">Peminjaman</a></li>
                        <li class="breadcrumb-item active">Detail #{{ $peminjaman->id }}</li>
                    </ol>
                </nav>
                <h1 class="page-title">Detail Peminjaman</h1>
            </div>

            <div class="row g-4">
                {{-- Info Utama --}}
                <div class="col-lg-8">
                    <div class="card-perpus">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-journal-text me-2"></i> Informasi Peminjaman</span>
                            @if($peminjaman->status === 'dipinjam' && $peminjaman->isTerlambat())
                                <span class="badge badge-status badge-terlambat">
                                    <i class="bi bi-exclamation-triangle me-1"></i> Terlambat {{ $peminjaman->hariTerlambat() }} hari
                                </span>
                            @elseif($peminjaman->status === 'dipinjam')
                                <span class="badge badge-status badge-dipinjam">Dipinjam</span>
                            @else
                                <span class="badge badge-status badge-dikembalikan">Dikembalikan</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                {{-- Data Anggota --}}
                                <div class="col-md-6">
                                    <h6 style="color: var(--teks-lembut); font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.75rem;">
                                        <i class="bi bi-person me-1"></i> Peminjam
                                    </h6>
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="d-flex align-items-center justify-content-center rounded-circle"
                                             style="width:48px;height:48px;background:var(--hijau-tua);color:var(--putih);font-size:1.1rem;font-weight:700;flex-shrink:0;">
                                            {{ strtoupper(substr($peminjaman->user->name ?? '?', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold" style="font-size:1rem;">{{ $peminjaman->user->name ?? '-' }}</div>
                                            <div style="color: var(--teks-lembut); font-size:0.85rem;">{{ $peminjaman->user->email ?? '' }}</div>
                                        </div>
                                    </div>
                                    <table style="font-size:0.88rem; line-height:2;">
                                        <tr>
                                            <td style="color: var(--teks-lembut); padding-right:1rem;">NIS/NIP</td>
                                            <td class="fw-semibold">{{ $peminjaman->user->nis_nip ?? '—' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: var(--teks-lembut); padding-right:1rem;">Kelas</td>
                                            <td class="fw-semibold">{{ $peminjaman->user->kelas ?? '—' }}</td>
                                        </tr>
                                    </table>
                                </div>

                                {{-- Data Buku --}}
                                <div class="col-md-6">
                                    <h6 style="color: var(--teks-lembut); font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.75rem;">
                                        <i class="bi bi-book me-1"></i> Buku
                                    </h6>
                                    <div class="fw-bold mb-1" style="font-size:1rem;">{{ $peminjaman->book->judul ?? '-' }}</div>
                                    <div style="color: var(--teks-lembut); font-size:0.88rem; margin-bottom:0.75rem;">{{ $peminjaman->book->pengarang ?? '' }}</div>
                                    <table style="font-size:0.88rem; line-height:2;">
                                        <tr>
                                            <td style="color: var(--teks-lembut); padding-right:1rem;">Penerbit</td>
                                            <td class="fw-semibold">{{ $peminjaman->book->penerbit ?? '—' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: var(--teks-lembut); padding-right:1rem;">ISBN</td>
                                            <td class="fw-semibold">{{ $peminjaman->book->isbn ?? '—' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: var(--teks-lembut); padding-right:1rem;">Stok saat ini</td>
                                            <td class="fw-semibold">{{ $peminjaman->book->stok ?? 0 }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <hr style="border-color: var(--garis); margin: 1.5rem 0;">

                            {{-- Data Peminjaman --}}
                            <h6 style="color: var(--teks-lembut); font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.75rem;">
                                <i class="bi bi-calendar3 me-1"></i> Detail Waktu
                            </h6>
                            <div class="row g-3">
                                <div class="col-sm-6 col-md-3">
                                    <div style="font-size:0.8rem; color:var(--teks-lembut); margin-bottom:0.25rem;">Tanggal Pinjam</div>
                                    <div class="fw-bold">{{ $peminjaman->tanggal_pinjam->format('d F Y') }}</div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div style="font-size:0.8rem; color:var(--teks-lembut); margin-bottom:0.25rem;">Batas Kembali</div>
                                    <div class="fw-bold" style="{{ $peminjaman->isTerlambat() ? 'color: var(--status-terlambat);' : '' }}">
                                        {{ $peminjaman->batas_kembali->format('d F Y') }}
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div style="font-size:0.8rem; color:var(--teks-lembut); margin-bottom:0.25rem;">Tanggal Kembali</div>
                                    <div class="fw-bold">
                                        {{ $peminjaman->tanggal_kembali ? $peminjaman->tanggal_kembali->format('d F Y') : '—' }}
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div style="font-size:0.8rem; color:var(--teks-lembut); margin-bottom:0.25rem;">Denda</div>
                                    <div class="fw-bold" style="{{ ($peminjaman->denda > 0 || ($peminjaman->status === 'dipinjam' && $peminjaman->isTerlambat())) ? 'color: var(--status-terlambat);' : '' }}">
                                        @if($peminjaman->status === 'dipinjam' && $peminjaman->isTerlambat())
                                            Rp{{ number_format($peminjaman->hitungDenda(), 0, ',', '.') }}
                                            <span style="font-size:0.75rem; font-weight:400;"> (sementara)</span>
                                        @elseif($peminjaman->denda > 0)
                                            Rp{{ number_format($peminjaman->denda, 0, ',', '.') }}
                                        @else
                                            —
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Aksi --}}
                <div class="col-lg-4">
                    <div class="card-perpus">
                        <div class="card-header">
                            <i class="bi bi-lightning me-2"></i> Aksi
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                @if($peminjaman->status === 'dipinjam')
                                <form method="POST" action="{{ route('admin.peminjaman.kembalikan', $peminjaman) }}"
                                      onsubmit="return confirm('Konfirmasi pengembalian buku?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-emas w-100">
                                        <i class="bi bi-box-arrow-in-down me-2"></i> Proses Pengembalian
                                    </button>
                                </form>

                                @if($peminjaman->isTerlambat())
                                <div class="alert alert-perpus alert-danger mt-2" style="font-size:0.85rem;">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    <div>
                                        Terlambat <strong>{{ $peminjaman->hariTerlambat() }} hari</strong>.
                                        Denda saat ini:
                                        <strong>Rp{{ number_format($peminjaman->hitungDenda(), 0, ',', '.') }}</strong>
                                    </div>
                                </div>
                                @endif
                                @else
                                <div class="alert alert-perpus alert-success" style="font-size:0.85rem;">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Buku sudah dikembalikan pada {{ $peminjaman->tanggal_kembali->format('d F Y') }}.</span>
                                </div>
                                @endif

                                <hr style="border-color: var(--garis);">

                                <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-hijau">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                                </a>

                                <form method="POST" action="{{ route('admin.peminjaman.destroy', $peminjaman) }}"
                                      onsubmit="return confirm('Yakin hapus data peminjaman ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="bi bi-trash me-1"></i> Hapus Data
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
