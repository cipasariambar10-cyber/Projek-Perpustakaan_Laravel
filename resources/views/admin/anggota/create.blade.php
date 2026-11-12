@extends('layouts.admin')

@section('title', 'Tambah Anggota — Perpustakaan')

@section('content')
            <div class="mb-4">
                <a href="{{ route('admin.anggota.index') }}" class="btn-back-nav mb-2">
                    <span class="back-nav-icon"><i class="bi bi-arrow-left"></i></span>
                    <span>Kembali ke Daftar Anggota</span>
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
                            {{-- NISN / NIP --}}
                            <div class="col-md-4 mb-3">
                                <label for="nis_nip" class="form-label" id="label-nis-nip">{{ old('role', 'anggota') === 'admin' ? 'NIP' : 'NISN' }}</label>
                                <input type="text"
                                       class="form-control @error('nis_nip') is-invalid @enderror"
                                       id="nis_nip" name="nis_nip" value="{{ old('nis_nip') }}"
                                       placeholder="{{ old('role', 'anggota') === 'admin' ? 'Contoh: 198501012010011001' : '10 digit NISN' }}">
                                @error('nis_nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kelas / Jabatan --}}
                            <div class="col-md-4 mb-3">
                                <label for="kelas" class="form-label" id="label-kelas">{{ old('role', 'anggota') === 'admin' ? 'Jabatan' : 'Kelas' }}</label>
                                <input type="text" class="form-control @error('kelas') is-invalid @enderror"
                                       id="kelas" name="kelas" value="{{ old('kelas') }}"
                                       placeholder="{{ old('role', 'anggota') === 'admin' ? 'Contoh: Pustakawan / Pengelola Perpustakaan' : 'Contoh: XII PPLG 1' }}">
                                @error('kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- No HP --}}
                            <div class="col-md-4 mb-3">
                                <label for="no_hp" class="form-label">No. HP</label>
                                <input type="tel" inputmode="numeric" minlength="10" maxlength="13" pattern="[0-9]{10,13}"
                                       class="form-control @error('no_hp') is-invalid @enderror"
                                       id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                                       placeholder="Contoh: 081234567890">
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
                            <button type="submit" class="btn btn-emas">
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');
        const labelNisNip = document.getElementById('label-nis-nip');
        const inputNisNip = document.getElementById('nis_nip');
        const labelKelas = document.getElementById('label-kelas');
        const inputKelas = document.getElementById('kelas');

        function updateRoleFields() {
            if (!roleSelect || !labelNisNip || !inputNisNip || !labelKelas || !inputKelas) return;

            const isAdmin = roleSelect.value === 'admin';
            if (isAdmin) {
                labelNisNip.textContent = 'NIP';
                inputNisNip.placeholder = 'Contoh: 198501012010011001';
                inputNisNip.removeAttribute('pattern');
                inputNisNip.removeAttribute('minlength');
                inputNisNip.oninput = null;
                inputNisNip.maxLength = 30;

                labelKelas.textContent = 'Jabatan';
                inputKelas.placeholder = 'Contoh: Pustakawan / Pengelola Perpustakaan';
                inputKelas.maxLength = 100;
            } else {
                labelNisNip.textContent = 'NISN';
                inputNisNip.placeholder = '10 digit NISN';
                inputNisNip.setAttribute('inputmode', 'numeric');
                inputNisNip.setAttribute('pattern', '[0-9]{10}');
                inputNisNip.setAttribute('minlength', '10');
                inputNisNip.oninput = function () {
                    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
                };
                inputNisNip.maxLength = 10;

                labelKelas.textContent = 'Kelas';
                inputKelas.placeholder = 'Contoh: XII PPLG 1';
                inputKelas.maxLength = 20;
            }
        }

        roleSelect.addEventListener('change', updateRoleFields);
        updateRoleFields();
    });
</script>
@endpush
