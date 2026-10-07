@extends('layouts.app')

@section('title', 'Daftar — Perpustakaan Sekolah')
@section('meta_description', 'Daftar akun baru untuk mengakses layanan perpustakaan sekolah.')
@section('hide_footer', true)

@section('content')
<div class="auth-wrapper">
    <div class="auth-card" style="max-width: 520px;">
        <div class="auth-logo">
            <i class="bi bi-person-plus-fill"></i>
            <h2>Daftar Akun</h2>
            <p>Buat akun untuk mulai meminjam buku</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="form-perpus">
            @csrf

            {{-- Nama Lengkap --}}
            <div class="mb-3">
                <label for="name" class="form-label">
                    <i class="bi bi-person me-1"></i> Nama Lengkap
                </label>
                <input type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Masukkan nama lengkap"
                       required
                       autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope me-1"></i> Email
                </label>
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="nama@email.com"
                       required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                {{-- NIS/NIP --}}
                <div class="col-md-6 mb-3">
                    <label for="nis_nip" class="form-label">
                        <i class="bi bi-card-text me-1"></i> NISN
                    </label>
                    <input type="text"
                           class="form-control @error('nis_nip') is-invalid @enderror"
                           id="nis_nip"
                           name="nis_nip"
                           value="{{ old('nis_nip') }}"
                           placeholder="Nomor induk">
                    @error('nis_nip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kelas --}}
                <div class="col-md-6 mb-3">
                    <label for="kelas" class="form-label">
                        <i class="bi bi-mortarboard me-1"></i> Kelas
                    </label>
                    <input type="text"
                           class="form-control @error('kelas') is-invalid @enderror"
                           id="kelas"
                           name="kelas"
                           value="{{ old('kelas') }}"
                           placeholder="Contoh: XII PPLG 2">
                    @error('kelas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- No HP --}}
            <div class="mb-3">
                <label for="no_hp" class="form-label">
                    <i class="bi bi-phone me-1"></i> No. HP
                </label>
                <input type="text"
                       class="form-control @error('no_hp') is-invalid @enderror"
                       id="no_hp"
                       name="no_hp"
                       value="{{ old('no_hp') }}"
                       placeholder="08xxxxxxxxxx">
                @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="bi bi-lock me-1"></i> Password
                </label>
                <input type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       id="password"
                       name="password"
                       placeholder="Minimal 8 karakter"
                       required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">
                    <i class="bi bi-lock-fill me-1"></i> Konfirmasi Password
                </label>
                <input type="password"
                       class="form-control"
                       id="password_confirmation"
                       name="password_confirmation"
                       placeholder="Ketik ulang password"
                       required>
            </div>

            {{-- Tombol Daftar --}}
            <button type="submit" class="btn btn-hijau w-100 py-2 mb-3">
                <i class="bi bi-person-plus me-1"></i> Daftar
            </button>

            <p class="text-center mb-0" style="font-size: 0.9rem; color: var(--teks-lembut);">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="fw-semibold" style="color: var(--hijau-tua);">Masuk di sini</a>
            </p>
        </form>
    </div>
</div>
@endsection
