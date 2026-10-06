<div class="mb-3">
    <label for="nama" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
    <input type="text" id="nama" name="nama" maxlength="100"
           class="form-control @error('nama') is-invalid @enderror"
           value="{{ old('nama', $kategori->nama ?? '') }}" placeholder="Contoh: Novel" required autofocus>
    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="d-flex gap-2">
    <button type="submit" class="btn btn-hijau"><i class="bi bi-check-lg me-1"></i> Simpan</button>
    <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-hijau">Batal</a>
</div>
