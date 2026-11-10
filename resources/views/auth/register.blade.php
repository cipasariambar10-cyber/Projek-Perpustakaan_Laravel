@extends('layouts.app')

@section('title', 'Daftar — Perpustakaan Sekolah')
@section('meta_description', 'Daftar akun baru untuk mengakses layanan perpustakaan sekolah.')
@section('hide_footer', true)

@section('content')
<div class="auth-wrapper">
    <div class="auth-card" style="max-width: 520px;">
        <div class="auth-logo">
            <img src="{{ asset('images/logo-lentera-icon.png') }}" alt="Logo Lentera Pustaka" class="auth-logo-img mb-3">
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
                {{-- NISN --}}
                <div class="col-md-6 mb-3">
                    <label for="nis_nip" class="form-label">
                        <i class="bi bi-card-text me-1"></i> NISN
                    </label>
                    <input type="text"
                           class="form-control @error('nis_nip') is-invalid @enderror"
                           id="nis_nip"
                           name="nis_nip"
                           value="{{ old('nis_nip') }}"
                           placeholder="Contoh: 0071234567">
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
                <input type="tel"
                       inputmode="numeric"
                       class="form-control @error('no_hp') is-invalid @enderror"
                       id="no_hp"
                       name="no_hp"
                       value="{{ old('no_hp') }}"
                       minlength="10"
                       maxlength="13"
                       pattern="[0-9]{10,13}"
                       placeholder="08xxxxxxxxxx (10-13 digit angka)">
                <div id="no_hp_warning" class="invalid-feedback" style="{{ $errors->has('no_hp') ? 'display: block;' : 'display: none;' }}">
                    {{ $errors->first('no_hp') ?: 'Nomor telepon harus terdiri dari 10 hingga 13 digit angka.' }}
                </div>
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
            <button type="submit" class="btn btn-emas w-100 py-2 mb-3">
                <i class="bi bi-person-plus me-1"></i> Daftar
            </button>

            <p class="text-center mb-0" style="font-size: 0.9rem; color: var(--teks-lembut);">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="fw-semibold" style="color: var(--green-800);">Masuk di sini</a>
            </p>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const noHpInput = document.getElementById('no_hp');
    const noHpWarning = document.getElementById('no_hp_warning');
    if (!noHpInput || !noHpWarning) return;

    function validatePhone() {
        // Hanya izinkan karakter angka
        const cleaned = noHpInput.value.replace(/[^0-9]/g, '');
        if (noHpInput.value !== cleaned) {
            noHpInput.value = cleaned;
        }

        const len = cleaned.length;
        if (len === 0) {
            noHpInput.classList.remove('is-invalid', 'is-valid');
            noHpInput.setCustomValidity('');
            noHpWarning.style.display = 'none';
        } else if (len < 10) {
            noHpInput.classList.add('is-invalid');
            noHpInput.classList.remove('is-valid');
            const msg = 'Nomor telepon terlalu pendek (' + len + ' digit). Minimal 10 digit angka.';
            noHpWarning.textContent = msg;
            noHpWarning.style.display = 'block';
            noHpInput.setCustomValidity(msg);
        } else if (len > 13) {
            noHpInput.classList.add('is-invalid');
            noHpInput.classList.remove('is-valid');
            const msg = 'Nomor telepon terlalu panjang (' + len + ' digit). Maksimal 13 digit angka.';
            noHpWarning.textContent = msg;
            noHpWarning.style.display = 'block';
            noHpInput.setCustomValidity(msg);
        } else {
            noHpInput.classList.remove('is-invalid');
            noHpInput.classList.add('is-valid');
            noHpInput.setCustomValidity('');
            noHpWarning.style.display = 'none';
        }
    }

    noHpInput.addEventListener('input', validatePhone);
    noHpInput.addEventListener('blur', validatePhone);
});
</script>
@endpush
