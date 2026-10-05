@php($b = $buku ?? null)
<div class="row g-3">
    <div class="col-md-8">
        <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
        <input type="text" id="judul" name="judul" maxlength="255" required
               class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $b->judul ?? '') }}">
        @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
        <select id="category_id" name="category_id" required class="form-select @error('category_id') is-invalid @enderror">
            <option value="">— Pilih kategori —</option>
            @foreach($kategori as $k)
                <option value="{{ $k->id }}" @selected(old('category_id', $b->category_id ?? '') == $k->id)>{{ $k->nama }}</option>
            @endforeach
        </select>
        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="pengarang" class="form-label">Pengarang <span class="text-danger">*</span></label>
        <input type="text" id="pengarang" name="pengarang" maxlength="255" required
               class="form-control @error('pengarang') is-invalid @enderror" value="{{ old('pengarang', $b->pengarang ?? '') }}">
        @error('pengarang')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="penerbit" class="form-label">Penerbit <span class="text-danger">*</span></label>
        <input type="text" id="penerbit" name="penerbit" maxlength="255" required
               class="form-control @error('penerbit') is-invalid @enderror" value="{{ old('penerbit', $b->penerbit ?? '') }}">
        @error('penerbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label for="tahun_terbit" class="form-label">Tahun Terbit <span class="text-danger">*</span></label>
        <input type="number" id="tahun_terbit" name="tahun_terbit" min="1000" max="{{ date('Y') }}" required
               class="form-control @error('tahun_terbit') is-invalid @enderror" value="{{ old('tahun_terbit', $b->tahun_terbit ?? '') }}">
        @error('tahun_terbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-5">
        <label for="isbn" class="form-label">ISBN</label>
        <input type="text" id="isbn" name="isbn" maxlength="20"
               class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn', $b->isbn ?? '') }}">
        @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-2">
        <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
        <input type="number" id="stok" name="stok" min="0" required
               class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $b->stok ?? 1) }}">
        @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-2">
        <label for="lokasi_rak" class="form-label">Lokasi Rak</label>
        <input type="text" id="lokasi_rak" name="lokasi_rak" maxlength="50" placeholder="A-01"
               class="form-control @error('lokasi_rak') is-invalid @enderror" value="{{ old('lokasi_rak', $b->lokasi_rak ?? '') }}">
        @error('lokasi_rak')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label for="sinopsis" class="form-label">Sinopsis</label>
        <textarea id="sinopsis" name="sinopsis" rows="5"
                  class="form-control @error('sinopsis') is-invalid @enderror">{{ old('sinopsis', $b->sinopsis ?? '') }}</textarea>
        @error('sinopsis')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-hijau"><i class="bi bi-check-lg me-1"></i> Simpan</button>
    <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-hijau">Batal</a>
</div>
