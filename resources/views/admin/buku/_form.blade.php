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
    <div class="col-md-2">
        <label for="tahun_terbit" class="form-label">Tahun Terbit <span class="text-danger">*</span></label>
        <input type="number" id="tahun_terbit" name="tahun_terbit" min="1000" max="{{ date('Y') }}" required
               class="form-control @error('tahun_terbit') is-invalid @enderror" value="{{ old('tahun_terbit', $b->tahun_terbit ?? '') }}">
        @error('tahun_terbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label for="isbn" class="form-label">ISBN</label>
        <input type="text" id="isbn" name="isbn" maxlength="20"
               class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn', $b->isbn ?? '') }}">
        @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-2">
        <label for="jumlah_halaman" class="form-label">Jml Halaman</label>
        <input type="number" id="jumlah_halaman" name="jumlah_halaman" min="1" placeholder="250"
               class="form-control @error('jumlah_halaman') is-invalid @enderror" value="{{ old('jumlah_halaman', $b->jumlah_halaman ?? '') }}">
        @error('jumlah_halaman')<div class="invalid-feedback">{{ $message }}</div>@enderror
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

    {{-- Upload Foto Sampul / Cover Buku & Sinopsis --}}
    <div class="col-md-4">
        <label for="sampul" class="form-label">Foto Sampul / Cover Buku</label>
        <div class="d-flex align-items-start gap-3 p-3 rounded-3" style="border: 1.5px dashed var(--garis-gold); background: rgba(212, 162, 76, 0.04);">
            <div class="flex-shrink-0">
                <img id="preview-sampul"
                     src="{{ !empty($b?->sampul) ? asset('storage/' . $b->sampul) : '' }}"
                     alt="Preview Sampul"
                     class="rounded-3 shadow-sm {{ empty($b?->sampul) ? 'd-none' : '' }}"
                     style="width: 72px; height: 104px; object-fit: cover; border: 1px solid var(--garis-gold);">
                <div id="placeholder-sampul"
                     class="rounded-3 d-flex flex-column align-items-center justify-content-center text-center {{ !empty($b?->sampul) ? 'd-none' : '' }}"
                     style="width: 72px; height: 104px; background: var(--gradient-green); color: var(--gold-300); border: 1px solid var(--garis-gold);">
                    <i class="bi bi-image" style="font-size: 1.4rem;"></i>
                    <span style="font-size: 0.62rem; color: var(--cream-100); margin-top: 2px;">Cover</span>
                </div>
            </div>
            <div class="flex-grow-1">
                <input type="file" id="sampul" name="sampul" accept="image/jpeg,image/png,image/webp"
                       class="form-control form-control-sm @error('sampul') is-invalid @enderror"
                       onchange="previewCoverBook(this)">
                <div class="form-text mt-1" style="font-size: 0.76rem;">
                    Format: JPG, PNG, atau WEBP (Maks. 2MB).
                    @if(!empty($b?->sampul))
                        <br>Biarkan kosong jika tidak ingin mengubah sampul.
                    @endif
                </div>
                @error('sampul')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <label for="sinopsis" class="form-label">Sinopsis</label>
        <textarea id="sinopsis" name="sinopsis" rows="4"
                  class="form-control @error('sinopsis') is-invalid @enderror">{{ old('sinopsis', $b->sinopsis ?? '') }}</textarea>
        @error('sinopsis')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-emas"><i class="bi bi-check-lg me-1"></i> Simpan</button>
    <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-hijau">Batal</a>
</div>

<script>
function previewCoverBook(input) {
    const preview = document.getElementById('preview-sampul');
    const placeholder = document.getElementById('placeholder-sampul');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            if (placeholder) placeholder.classList.add('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
