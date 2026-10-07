@extends('layouts.app')

@section('title', 'Masuk — Perpustakaan Sekolah')
@section('meta_description', 'Masuk ke sistem perpustakaan sekolah untuk meminjam buku dan mengelola akun Anda.')
@section('hide_footer', true)

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-logo">
            <i class="bi bi-book-half"></i>
            <h2>Selamat Datang</h2>
            <p>Masuk ke akun perpustakaan Anda</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="form-perpus">
            @csrf

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
                       required
                       autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="bi bi-lock me-1"></i> Password
                </label>
                <div class="input-group">
                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           id="password"
                           name="password"
                           placeholder="Masukkan password"
                           required>
                    <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword()">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Ingat Saya --}}
            <div class="mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember" style="font-size: 0.88rem;">
                        Ingat saya
                    </label>
                </div>
            </div>

            {{-- Tombol Masuk --}}
            <button type="submit" class="btn btn-hijau w-100 py-2 mb-3">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
            </button>

            <p class="text-center mb-0" style="font-size: 0.9rem; color: var(--teks-lembut);">
                Belum punya akun?
                <a href="{{ route('register') }}" class="fw-semibold" style="color: var(--hijau-tua);">Daftar sekarang</a>
            </p>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>
@endpush
