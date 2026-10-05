@extends('layouts.admin')

@section('title', 'Kelola Buku — Lentera Pustaka')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="page-title">Kelola Buku</h1>
        <p class="page-subtitle mb-0">Daftar koleksi buku perpustakaan</p>
    </div>
    <a href="{{ route('admin.buku.create') }}" class="btn btn-hijau">
        <i class="bi bi-plus-circle me-1"></i> Tambah Buku
    </a>
</div>

<div class="card-perpus mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.buku.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label for="q" class="form-label" style="font-size:0.85rem;">Cari</label>
                <input type="text" id="q" name="q" class="form-control" placeholder="Judul atau pengarang..."
                       value="{{ request('q') }}" style="border-color:var(--garis-tebal);">
            </div>
            <div class="col-md-4">
                <label for="kategori" class="form-label" style="font-size:0.85rem;">Kategori</label>
                <select id="kategori" name="kategori" class="form-select" style="border-color:var(--garis-tebal);">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}" @selected(request('kategori') == $k->id)>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-hijau btn-sm flex-fill"><i class="bi bi-funnel me-1"></i> Filter</button>
                <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-hijau btn-sm" title="Reset"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card-perpus">
    <div class="card-body p-0">
        @if($buku->count() > 0)
        <div class="table-responsive">
            <table class="table table-perpus mb-0">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Kategori</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th>Rak</th>
                        <th style="width:150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buku as $i => $b)
                    <tr>
                        <td class="text-lembut">{{ $buku->firstItem() + $i }}</td>
                        <td>
                            <div class="fw-semibold" style="font-size:0.88rem;">{{ $b->judul }}</div>
                            <div class="text-lembut" style="font-size:0.78rem;">ISBN: {{ $b->isbn ?? '-' }}</div>
                        </td>
                        <td>{{ $b->pengarang }}</td>
                        <td>{{ $b->category->nama ?? '-' }}</td>
                        <td>{{ $b->tahun_terbit }}</td>
                        <td>
                            <span class="badge badge-status {{ $b->stok > 0 ? 'badge-dikembalikan' : 'badge-terlambat' }}">{{ $b->stok }}</span>
                        </td>
                        <td>{{ $b->lokasi_rak ?? '-' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('katalog.show', $b) }}" class="btn btn-sm btn-outline-secondary" title="Detail"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.buku.edit', $b) }}" class="btn btn-sm btn-outline-secondary" title="Ubah"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('admin.buku.destroy', $b) }}"
                                      onsubmit="return confirm('Hapus buku {{ addslashes($b->judul) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($buku->hasPages())
        <div class="d-flex justify-content-between align-items-center px-3 py-3">
            <div class="text-lembut" style="font-size:0.85rem;">
                Menampilkan {{ $buku->firstItem() }}–{{ $buku->lastItem() }} dari {{ $buku->total() }} data
            </div>
            {{ $buku->links() }}
        </div>
        @endif
        @else
        <div class="empty-state">
            <i class="bi bi-book"></i>
            <h5>Tidak Ada Buku</h5>
            <p>
                @if(request()->hasAny(['q', 'kategori']))
                    Tidak ada buku yang cocok dengan filter. <a href="{{ route('admin.buku.index') }}">Reset filter</a>
                @else
                    Belum ada buku. Tambahkan buku pertama.
                @endif
            </p>
        </div>
        @endif
    </div>
</div>
@endsection
