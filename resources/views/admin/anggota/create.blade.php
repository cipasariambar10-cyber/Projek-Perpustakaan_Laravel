@extends('layouts.admin')

@section('title', 'Tambah Anggota — Perpustakaan')

@section('content')
            <div class="mb-4">
                <a href="{{ route('admin.anggota.index') }}" class="text-lembut" style="font-size:0.88rem;">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Anggota
                </a>
                <h1 class="page-title mt-2">Tambah Anggota</h1>
                <p class="page-subtitle mb-0">Tambahkan pengguna baru ke sistem perpustakaan</p>
            </div>

            <div class="card-perpus" style="max-width: 700px;">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.anggota.store') }}" class="form-perpus">
                        @csrf

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- Role --}}
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                    <option value="anggota" {{ old('role', 'anggota') == 'anggota' ? 'selected' : '' }}>Anggota</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- NISN --}}
                            <div class="col-md-4 mb-3">
                                <label for="nis_nip" class="form-label">NISN</label>
                                <input type="text" class="form-control @error('nis_nip') is-invalid @enderror"
                                       id="nis_nip" name="nis_nip" value="{{ old('nis_nip') }}">
                                @error('nis_nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kelas --}}
                            <div class="col-md-4 mb-3">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input type="text" class="form-control @error('kelas') is-invalid @enderror"
                                       id="kelas" name="kelas" value="{{ old('kelas') }}" placeholder="XII IPA 1">
                                @error('kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- No HP --}}
                            <div class="col-md-4 mb-3">
                                <label for="no_hp" class="form-label">No. HP</label>
                                <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                       id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx">
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr style="border-color: var(--garis);">

                        {{-- Password --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" placeholder="Minimal 8 karakter" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation"
                                       name="password_confirmation" placeholder="Ketik ulang password" required>
                            </div>
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-hijau">
                                <i class="bi bi-check-lg me-1"></i> Simpan
                            </button>
                            <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-hijau">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
@endsection
