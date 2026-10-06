@extends('layouts.admin')

@section('title', 'Kelola Kategori — Lentera Pustaka')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="page-title">Kelola Kategori</h1>
        <p class="page-subtitle mb-0">Daftar kategori buku perpustakaan</p>
    </div>
    <a href="{{ route('admin.kategori.create') }}" class="btn btn-hijau">
        <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
    </a>
</div>

<div class="card-perpus">
    <div class="card-body p-0">
        @if($kategori->count() > 0)
        <div class="table-responsive">
            <table class="table table-perpus mb-0">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Buku</th>
                        <th style="width:130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategori as $i => $k)
                    <tr>
                        <td class="text-lembut">{{ $kategori->firstItem() + $i }}</td>
                        <td class="fw-semibold">{{ $k->nama }}</td>
                        <td>{{ $k->books_count }} buku</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.kategori.edit', $k) }}" class="btn btn-sm btn-outline-secondary" title="Ubah">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.kategori.destroy', $k) }}"
                                      onsubmit="return confirm('Hapus kategori {{ addslashes($k->nama) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
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

        @if($kategori->hasPages())
        <div class="d-flex justify-content-between align-items-center px-3 py-3">
            <div class="text-lembut" style="font-size:0.85rem;">
                Menampilkan {{ $kategori->firstItem() }}–{{ $kategori->lastItem() }} dari {{ $kategori->total() }} data
            </div>
            {{ $kategori->links() }}
        </div>
        @endif
        @else
        <div class="empty-state">
            <i class="bi bi-tags"></i>
            <h5>Belum Ada Kategori</h5>
            <p>Tambahkan kategori pertama untuk mengelompokkan buku.</p>
        </div>
        @endif
    </div>
</div>
@endsection
