@extends('layouts.admin')

@section('title', 'Dashboard Admin — Perpustakaan')

@section('content')
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="page-title">Dashboard</h1>
                    <p class="page-subtitle mb-0">Selamat datang, {{ auth()->user()->name }}!</p>
                </div>
                <span class="text-lembut" style="font-size: 0.85rem;">
                    <i class="bi bi-calendar3 me-1"></i> {{ now()->format('d F Y') }}
                </span>
            </div>

            {{-- Kartu Statistik --}}
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-book-half"></i></div>
                        <div class="stat-number">{{ number_format($stats['total_buku']) }}</div>
                        <div class="stat-label">Total Buku</div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                        <div class="stat-number">{{ number_format($stats['anggota_aktif']) }}</div>
                        <div class="stat-label">Anggota Aktif</div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="color: var(--status-dipinjam);"><i class="bi bi-arrow-left-right"></i></div>
                        <div class="stat-number" style="color: var(--status-dipinjam);">{{ number_format($stats['total_dipinjam']) }}</div>
                        <div class="stat-label">Sedang Dipinjam</div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="color: var(--status-terlambat);"><i class="bi bi-exclamation-triangle-fill"></i></div>
                        <div class="stat-number" style="color: var(--status-terlambat);">{{ number_format($stats['total_terlambat']) }}</div>
                        <div class="stat-label">Terlambat</div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                {{-- Anggota Terbaru --}}
                <div class="col-lg-7">
                    <div class="card-perpus">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-people me-2"></i> Anggota Terbaru</span>
                            <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-hijau btn-sm" style="font-size:0.78rem;">
                                Lihat Semua
                            </a>
                        </div>
                        <div class="card-body p-0">
                            @if($anggotaTerbaru->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-perpus mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>NIS/NIP</th>
                                            <th>Kelas</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($anggotaTerbaru as $a)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="d-flex align-items-center justify-content-center rounded-circle"
                                                         style="width:32px;height:32px;background:var(--hijau-tua);color:var(--putih);font-size:0.75rem;font-weight:600;flex-shrink:0;">
                                                        {{ strtoupper(substr($a->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold" style="font-size:0.88rem;">{{ $a->name }}</div>
                                                        <div class="text-lembut" style="font-size:0.78rem;">{{ $a->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $a->nis_nip ?? '-' }}</td>
                                            <td>{{ $a->kelas ?? '-' }}</td>
                                            <td>
                                                <span class="badge badge-status {{ $a->status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                                                    {{ ucfirst($a->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="empty-state py-4">
                                <i class="bi bi-people" style="font-size:2.5rem;"></i>
                                <p class="mb-0">Belum ada anggota terdaftar.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Ringkasan Cepat --}}
                <div class="col-lg-5">
                    <div class="card-perpus">
                        <div class="card-header">
                            <i class="bi bi-info-circle me-2"></i> Ringkasan
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex justify-content-between align-items-center py-2 border-bottom" style="border-color: var(--garis) !important;">
                                    <span class="text-lembut"><i class="bi bi-person-badge me-2"></i> Total Admin</span>
                                    <span class="fw-bold" style="color: var(--hijau-tua);">{{ $stats['total_admin'] }}</span>
                                </li>
                                <li class="d-flex justify-content-between align-items-center py-2 border-bottom" style="border-color: var(--garis) !important;">
                                    <span class="text-lembut"><i class="bi bi-people me-2"></i> Total Anggota</span>
                                    <span class="fw-bold" style="color: var(--hijau-tua);">{{ $stats['total_anggota'] }}</span>
                                </li>
                                <li class="d-flex justify-content-between align-items-center py-2 border-bottom" style="border-color: var(--garis) !important;">
                                    <span class="text-lembut"><i class="bi bi-check-circle me-2"></i> Anggota Aktif</span>
                                    <span class="fw-bold" style="color: var(--status-dikembalikan);">{{ $stats['anggota_aktif'] }}</span>
                                </li>
                                <li class="d-flex justify-content-between align-items-center py-2">
                                    <span class="text-lembut"><i class="bi bi-book me-2"></i> Koleksi Buku</span>
                                    <span class="fw-bold" style="color: var(--hijau-tua);">{{ number_format($stats['total_buku']) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Aksi Cepat --}}
                    <div class="card-perpus mt-4">
                        <div class="card-header">
                            <i class="bi bi-lightning me-2"></i> Aksi Cepat
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.anggota.create') }}" class="btn btn-hijau btn-sm">
                                    <i class="bi bi-person-plus me-2"></i> Tambah Anggota
                                </a>
                                @if(Route::has('admin.buku.create'))
                                <a href="{{ route('admin.buku.create') }}" class="btn btn-outline-hijau btn-sm">
                                    <i class="bi bi-plus-circle me-2"></i> Tambah Buku
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
