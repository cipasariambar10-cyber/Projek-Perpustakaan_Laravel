@props(['book', 'showActions' => true])

<div class="card h-100 border-0 book-card">
    {{-- Frame Sampul Buku 3D dengan Efek Lipatan Punggung Buku (Book Spine) --}}
    <div class="book-cover-stage">
        <a href="{{ route('katalog.show', $book->id) }}" class="d-block text-decoration-none book-cover-container">
            @if($book->sampul)
                <img src="{{ asset('storage/' . $book->sampul) }}" class="card-img-top book-cover" alt="Cover {{ $book->judul }}">
            @else
                <div class="book-cover-placeholder">
                    <i class="bi bi-book"></i>
                    <span>Tanpa Sampul</span>
                </div>
            @endif
            <div class="book-spine-effect" aria-hidden="true"></div>
        </a>

        {{-- Lencana Glassmorphism Status Stok --}}
        <div class="book-stock-badge-wrap">
            @if($book->stok > 0)
                <span class="book-stock-pill stock-available">
                    <span class="stock-dot"></span>
                    <span>Tersedia {{ $book->stok }}</span>
                </span>
            @else
                <span class="book-stock-pill stock-empty">
                    <span class="stock-dot"></span>
                    <span>Stok Habis</span>
                </span>
            @endif
        </div>
    </div>

    {{-- Isi Kartu Buku --}}
    <div class="card-body d-flex flex-column">
        <div class="book-info-top">
            <div class="book-meta-top">
                <span class="book-category-pill">{{ $book->category ? $book->category->nama : 'UMUM' }}</span>
                @if(!empty($book->tahun_terbit))
                    <span class="book-year-tag"><i class="bi bi-calendar3"></i> {{ $book->tahun_terbit }}</span>
                @endif
            </div>

            <a href="{{ route('katalog.show', $book->id) }}" class="text-decoration-none">
                <h5 class="card-title book-title" title="{{ $book->judul }}">
                    {{ $book->judul }}
                </h5>
            </a>

            <p class="card-text book-author" title="{{ $book->pengarang }}">
                <i class="bi bi-feather me-1"></i>{{ $book->pengarang }}
            </p>
        </div>

        @if($showActions)
        {{-- Bar Aksi Modern: Detail & Pinjam (Khusus Halaman Katalog) --}}
        <div class="book-actions">
            <a href="{{ route('katalog.show', $book->id) }}" class="btn-book-action btn-book-detail">
                <i class="bi bi-journal-text"></i>
                <span>Detail</span>
            </a>
            <form action="{{ route('katalog.pinjam', $book->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-book-action btn-book-pinjam" {{ $book->stok <= 0 ? 'disabled' : '' }}>
                    @if($book->stok > 0)
                        <i class="bi bi-bookmark-plus-fill"></i>
                        <span>Pinjam</span>
                    @else
                        <i class="bi bi-slash-circle"></i>
                        <span>Habis</span>
                    @endif
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
