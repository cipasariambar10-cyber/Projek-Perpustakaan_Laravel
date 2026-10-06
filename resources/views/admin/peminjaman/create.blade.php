@extends('layouts.admin')

@section('title', 'Catat Peminjaman — Perpustakaan')

@section('content')
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" style="font-size:0.85rem;">
                        <li class="breadcrumb-item"><a href="{{ route('admin.peminjaman.index') }}">Peminjaman</a></li>
                        <li class="breadcrumb-item active">Catat Baru</li>
                    </ol>
                </nav>
                <h1 class="page-title">Catat Peminjaman Baru</h1>
                <p class="page-subtitle mb-0">Pilih anggota dan buku yang akan dipinjam</p>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card-perpus">
                        <div class="card-header">
                            <i class="bi bi-plus-circle me-2"></i> Form Peminjaman
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.peminjaman.store') }}" class="form-perpus">
                                @csrf

                                {{-- Pilih Anggota --}}
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">
                                        <i class="bi bi-person me-1"></i> Anggota <span style="color: var(--status-terlambat);">*</span>
                                    </label>
                                    <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                        <option value="">— Pilih Anggota —</option>
                                        @foreach($anggota as $a)
                                            <option value="{{ $a->id }}" {{ old('user_id') == $a->id ? 'selected' : '' }}>
                                                {{ $a->name }} {{ $a->nis_nip ? '(' . $a->nis_nip . ')' : '' }} {{ $a->kelas ? '— ' . $a->kelas : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if($anggota->isEmpty())
                                        <div class="form-text" style="color: var(--status-terlambat);">
                                            <i class="bi bi-exclamation-circle me-1"></i> Belum ada anggota aktif. Tambahkan anggota terlebih dahulu.
                                        </div>
                                    @endif
                                </div>

                                {{-- Pilih Buku --}}
                                <div class="mb-3">
                                    <label for="book_id" class="form-label">
                                        <i class="bi bi-book me-1"></i> Buku <span style="color: var(--status-terlambat);">*</span>
                                    </label>
                                    <select name="book_id" id="book_id" class="form-select @error('book_id') is-invalid @enderror" required>
                                        <option value="">— Pilih Buku —</option>
                                        @foreach($buku as $b)
                                            <option value="{{ $b->id }}" {{ old('book_id') == $b->id ? 'selected' : '' }}>
                                                {{ $b->judul }} — {{ $b->pengarang }} (Stok: {{ $b->stok }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('book_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if($buku->isEmpty())
                                        <div class="form-text" style="color: var(--status-terlambat);">
                                            <i class="bi bi-exclamation-circle me-1"></i> Tidak ada buku tersedia. Tambahkan buku atau periksa stok.
                                        </div>
                                    @endif
                                </div>

                                {{-- Tanggal Pinjam --}}
                                <div class="mb-4">
                                    <label for="tanggal_pinjam" class="form-label">
                                        <i class="bi bi-calendar-event me-1"></i> Tanggal Pinjam <span style="color: var(--status-terlambat);">*</span>
                                    </label>
                                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                                           class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                                           value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                                    @error('tanggal_pinjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i> Batas pengembalian otomatis dihitung <strong>7 hari</strong> dari tanggal pinjam.
                                    </div>
                                </div>

                                <hr style="border-color: var(--garis);">

                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-hijau">
                                        <i class="bi bi-arrow-left me-1"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-hijau">
                                        <i class="bi bi-check-lg me-1"></i> Simpan Peminjaman
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Info Samping --}}
                <div class="col-lg-4">
                    <div class="card-perpus">
                        <div class="card-header">
                            <i class="bi bi-info-circle me-2"></i> Aturan Peminjaman
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0" style="font-size:0.88rem; line-height:2;">
                                <li>
                                    <i class="bi bi-clock me-2" style="color: var(--emas);"></i>
                                    Lama pinjam: <strong>7 hari</strong>
                                </li>
                                <li>
                                    <i class="bi bi-cash me-2" style="color: var(--emas);"></i>
                                    Denda: <strong>Rp1.000/hari</strong> terlambat
                                </li>
                                <li>
                                    <i class="bi bi-person-check me-2" style="color: var(--emas);"></i>
                                    Hanya anggota <strong>aktif</strong>
                                </li>
                                <li>
                                    <i class="bi bi-book me-2" style="color: var(--emas);"></i>
                                    Stok berkurang <strong>otomatis</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
@endsection
