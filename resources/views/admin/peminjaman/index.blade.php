@extends('layouts.admin')

@section('title', 'Kelola Peminjaman — Perpustakaan')

@section('content')
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="page-title">Peminjaman</h1>
                    <p class="page-subtitle mb-0">Kelola peminjaman dan pengembalian buku</p>
                </div>
                <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-hijau">
                    <i class="bi bi-plus-circle me-2"></i> Catat Peminjaman
                </a>
            </div>

            {{-- Kartu Statistik Peminjaman --}}
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="stat-card" style="padding:1rem;">
                        <div class="stat-number" style="font-size:1.5rem;">{{ number_format($stats['total']) }}</div>
                        <div class="stat-label">Total Transaksi</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card" style="padding:1rem;">
                        <div class="stat-number" style="font-size:1.5rem; color: var(--status-dipinjam);">{{ number_format($stats['dipinjam']) }}</div>
                        <div class="stat-label">Sedang Dipinjam</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card" style="padding:1rem;">
                        <div class="stat-number" style="font-size:1.5rem; color: var(--status-dikembalikan);">{{ number_format($stats['dikembalikan']) }}</div>
                        <div class="stat-label">Dikembalikan</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card" style="padding:1rem;">
                        <div class="stat-number" style="font-size:1.5rem; color: var(--status-terlambat);">{{ number_format($stats['terlambat']) }}</div>
                        <div class="stat-label">Terlambat</div>
                    </div>
                </div>
            </div>

            {{-- Filter & Pencarian --}}
            <div class="card-perpus mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.peminjaman.index') }}" class="row g-3 align-items-end form-perpus">
                        <div class="col-md-5">
                            <label class="form-label"><i class="bi bi-search me-1"></i> Pencarian</label>
                            <input type="text" name="cari" class="form-control" placeholder="Nama anggota, NISN, atau judul buku..." value="{{ request('cari') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><i class="bi bi-funnel me-1"></i> Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-hijau flex-fill">
                                <i class="bi bi-search me-1"></i> Cari
                            </button>
                            @if(request()->hasAny(['cari', 'status']))
                            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-hijau">
                                <i class="bi bi-x-lg"></i>
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabel Peminjaman --}}
            <div class="card-perpus">
                <div class="card-body p-0">
                    @if($peminjaman->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-perpus mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Anggota</th>
                                    <th>Buku</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Batas Kembali</th>
                                    <th>Tgl Kembali</th>
                                    <th>Denda</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjaman as $i => $loan)
                                <tr>
                                    <td>{{ $peminjaman->firstItem() + $i }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle"
                                                 style="width:30px;height:30px;background:var(--hijau-tua);color:var(--putih);font-size:0.72rem;font-weight:600;flex-shrink:0;">
                                                {{ strtoupper(substr($loan->user->name ?? '?', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold" style="font-size:0.88rem;">{{ $loan->user->name ?? '-' }}</div>
                                                <div style="font-size:0.75rem; color: var(--teks-lembut);">{{ $loan->user->nis_nip ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold" style="font-size:0.88rem;">{{ $loan->book->judul ?? '-' }}</div>
                                        <div style="font-size:0.75rem; color: var(--teks-lembut);">{{ $loan->book->pengarang ?? '' }}</div>
                                    </td>
                                    <td style="white-space:nowrap;">{{ $loan->tanggal_pinjam->format('d/m/Y') }}</td>
                                    <td style="white-space:nowrap;">{{ $loan->batas_kembali->format('d/m/Y') }}</td>
                                    <td style="white-space:nowrap;">
                                        {{ $loan->tanggal_kembali ? $loan->tanggal_kembali->format('d/m/Y') : '—' }}
                                    </td>
                                    <td>
                                        @if($loan->denda > 0 || ($loan->status === 'dipinjam' && $loan->isTerlambat()))
                                            <span style="color: var(--status-terlambat); font-weight: 600;">
                                                Rp{{ number_format($loan->status === 'dipinjam' ? $loan->hitungDenda() : $loan->denda, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span style="color: var(--teks-muted);">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($loan->status === 'dipinjam' && $loan->isTerlambat())
                                            <span class="badge badge-status badge-terlambat">
                                                <i class="bi bi-exclamation-triangle me-1"></i> Terlambat
                                            </span>
                                        @elseif($loan->status === 'dipinjam')
                                            <span class="badge badge-status badge-dipinjam">Dipinjam</span>
                                        @else
                                            <span class="badge badge-status badge-dikembalikan">Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('admin.peminjaman.show', $loan) }}" class="btn btn-sm btn-outline-hijau" title="Detail" style="padding:0.25rem 0.5rem; font-size:0.78rem;">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            @if($loan->status === 'dipinjam')
                                            <form method="POST" action="{{ route('admin.peminjaman.kembalikan', $loan) }}" class="d-inline"
                                                  onsubmit="return confirm('Konfirmasi pengembalian buku?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-emas" title="Kembalikan" style="padding:0.25rem 0.5rem; font-size:0.78rem;">
                                                    <i class="bi bi-box-arrow-in-down"></i>
                                                </button>
                                            </form>
                                            @endif

                                            <form method="POST" action="{{ route('admin.peminjaman.destroy', $loan) }}" class="d-inline"
                                                  onsubmit="return confirm('Yakin hapus data peminjaman ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" style="padding:0.25rem 0.5rem; font-size:0.78rem;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($peminjaman->hasPages())
                    <div class="d-flex justify-content-center py-3">
                        {{ $peminjaman->links() }}
                    </div>
                    @endif

                    @else
                    <div class="empty-state py-5">
                        <i class="bi bi-arrow-left-right" style="font-size:3rem;"></i>
                        <p class="mb-1 fw-semibold">Belum ada data peminjaman</p>
                        <p class="mb-3" style="font-size:0.85rem;">Mulai catat peminjaman buku baru.</p>
                        <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-hijau btn-sm">
                            <i class="bi bi-plus-circle me-1"></i> Catat Peminjaman
                        </a>
                    </div>
                    @endif
                </div>
            </div>
@endsection
