@extends('layouts.admin')

@section('title', 'Kelola Anggota — Perpustakaan')

@section('content')
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h1 class="page-title">Kelola Anggota</h1>
                    <p class="page-subtitle mb-0">Daftar semua pengguna perpustakaan</p>
                </div>
                <a href="{{ route('admin.anggota.create') }}" class="btn btn-hijau">
                    <i class="bi bi-person-plus me-1"></i> Tambah Anggota
                </a>
            </div>

            {{-- Filter & Pencarian --}}
            <div class="card-perpus mb-4">
                <div class="card-body py-3">
                    <form method="GET" action="{{ route('admin.anggota.index') }}" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label" style="font-size:0.85rem;">Cari</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background:var(--putih);border-color:var(--garis-tebal);">
                                    <i class="bi bi-search" style="color:var(--teks-muted);"></i>
                                </span>
                                <input type="text" name="search" class="form-control" placeholder="Nama, email, atau NIS/NIP..."
                                       value="{{ request('search') }}" style="border-color:var(--garis-tebal);">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" style="font-size:0.85rem;">Role</label>
                            <select name="role" class="form-select" style="border-color:var(--garis-tebal);">
                                <option value="">Semua Role</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="anggota" {{ request('role') == 'anggota' ? 'selected' : '' }}>Anggota</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" style="font-size:0.85rem;">Status</label>
                            <select name="status" class="form-select" style="border-color:var(--garis-tebal);">
                                <option value="">Semua Status</option>
                                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-hijau btn-sm flex-fill">
                                    <i class="bi bi-funnel me-1"></i> Filter
                                </button>
                                <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-hijau btn-sm" title="Reset">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabel Anggota --}}
            <div class="card-perpus">
                <div class="card-body p-0">
                    @if($anggota->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-perpus mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">#</th>
                                    <th>Nama</th>
                                    <th>NIS/NIP</th>
                                    <th>Kelas</th>
                                    <th>No. HP</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th style="width: 160px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($anggota as $index => $a)
                                <tr>
                                    <td class="text-lembut">{{ $anggota->firstItem() + $index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle"
                                                 style="width:34px;height:34px;background:var(--hijau-tua);color:var(--putih);font-size:0.8rem;font-weight:600;flex-shrink:0;">
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
                                    <td>{{ $a->no_hp ?? '-' }}</td>
                                    <td>
                                        <span class="badge badge-status {{ $a->role === 'admin' ? 'badge-admin' : 'badge-anggota' }}">
                                            {{ ucfirst($a->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-status {{ $a->status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                                            {{ ucfirst($a->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.anggota.show', $a) }}" class="btn btn-sm btn-outline-secondary" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.anggota.edit', $a) }}" class="btn btn-sm btn-outline-secondary" title="Ubah">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @if($a->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.anggota.toggle-status', $a) }}"
                                                  onsubmit="return confirm('{{ $a->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} akun {{ $a->name }}?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $a->status === 'aktif' ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                                        title="{{ $a->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                    <i class="bi {{ $a->status === 'aktif' ? 'bi-person-x' : 'bi-person-check' }}"></i>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.anggota.destroy', $a) }}"
                                                  onsubmit="return confirm('Hapus permanen akun {{ $a->name }}? Aksi ini tidak dapat dibatalkan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($anggota->hasPages())
                    <div class="d-flex justify-content-between align-items-center px-3 py-3">
                        <div class="text-lembut" style="font-size:0.85rem;">
                            Menampilkan {{ $anggota->firstItem() }}–{{ $anggota->lastItem() }} dari {{ $anggota->total() }} data
                        </div>
                        {{ $anggota->links() }}
                    </div>
                    @endif

                    @else
                    <div class="empty-state">
                        <i class="bi bi-people"></i>
                        <h5>Tidak Ada Data</h5>
                        <p>
                            @if(request()->hasAny(['search', 'role', 'status']))
                                Tidak ada anggota yang cocok dengan filter pencarian.
                                <a href="{{ route('admin.anggota.index') }}">Reset filter</a>
                            @else
                                Belum ada anggota terdaftar.
                            @endif
                        </p>
                    </div>
                    @endif
                </div>
            </div>
@endsection
