@extends('layouts.admin')

@section('title', $anggota->name . ' — Detail Anggota')

@section('content')
            <div class="mb-4">
                <a href="{{ route('admin.anggota.index') }}" class="text-lembut" style="font-size:0.88rem;">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Anggota
                </a>
                <h1 class="page-title mt-2">Detail Anggota</h1>
            </div>

            <div class="row g-4">
                {{-- Informasi Utama --}}
                <div class="col-lg-8">
                    <div class="card-perpus">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Informasi Anggota</span>
                            <a href="{{ route('admin.anggota.edit', $anggota) }}" class="btn btn-outline-hijau btn-sm">
                                <i class="bi bi-pencil me-1"></i> Ubah
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom: 1px solid var(--garis);">
                                <div class="d-flex align-items-center justify-content-center rounded-circle"
                                     style="width:64px;height:64px;background:var(--hijau-tua);color:var(--putih);font-size:1.6rem;font-weight:700;flex-shrink:0;">
                                    {{ strtoupper(substr($anggota->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 style="font-family: var(--font-judul); color: var(--hijau-tua); margin-bottom: 0.25rem;">
                                        {{ $anggota->name }}
                                    </h4>
                                    <div class="d-flex gap-2 align-items-center">
                                        <span class="badge badge-status {{ $anggota->role === 'admin' ? 'badge-admin' : 'badge-anggota' }}">
                                            {{ ucfirst($anggota->role) }}
                                        </span>
                                        <span class="badge badge-status {{ $anggota->status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                                            {{ ucfirst($anggota->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-lembut" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em;">Email</label>
                                    <div class="fw-semibold">{{ $anggota->email }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-lembut" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em;">NISN</label>
                                    <div class="fw-semibold">{{ $anggota->nis_nip ?? '-' }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-lembut" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em;">Kelas</label>
                                    <div class="fw-semibold">{{ $anggota->kelas ?? '-' }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-lembut" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em;">No. HP</label>
                                    <div class="fw-semibold">{{ $anggota->no_hp ?? '-' }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-lembut" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em;">Terdaftar</label>
                                    <div class="fw-semibold">{{ $anggota->created_at->translatedFormat('d F Y, H:i') }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-lembut" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em;">Terakhir Diperbarui</label>
                                    <div class="fw-semibold">{{ $anggota->updated_at->translatedFormat('d F Y, H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Statistik Peminjaman --}}
                <div class="col-lg-4">
                    <div class="card-perpus">
                        <div class="card-header">
                            <i class="bi bi-bar-chart me-2"></i> Statistik Peminjaman
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="border-color: var(--garis) !important;">
                                <span class="text-lembut">Total Pinjam</span>
                                <span class="fw-bold" style="color: var(--hijau-tua);">{{ $stats['total_pinjam'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="border-color: var(--garis) !important;">
                                <span class="text-lembut">Sedang Dipinjam</span>
                                <span class="fw-bold" style="color: var(--status-dipinjam);">{{ $stats['sedang_dipinjam'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <span class="text-lembut">Terlambat</span>
                                <span class="fw-bold" style="color: var(--status-terlambat);">{{ $stats['terlambat'] }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Aksi --}}
                    <div class="card-perpus mt-4">
                        <div class="card-header">
                            <i class="bi bi-gear me-2"></i> Aksi
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.anggota.edit', $anggota) }}" class="btn btn-hijau btn-sm">
                                    <i class="bi bi-pencil me-2"></i> Ubah Data
                                </a>
                                @if($anggota->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.anggota.toggle-status', $anggota) }}"
                                      onsubmit="return confirm('{{ $anggota->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} akun ini?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn {{ $anggota->status === 'aktif' ? 'btn-outline-danger' : 'btn-outline-success' }} btn-sm w-100">
                                        <i class="bi {{ $anggota->status === 'aktif' ? 'bi-person-x' : 'bi-person-check' }} me-2"></i>
                                        {{ $anggota->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} Akun
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
