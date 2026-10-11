@props(['book'])

<div class="card h-100 shadow-sm border-0 rounded-4 book-card">
    <div class="position-relative book-cover-container">
        @if($book->sampul)
            <img src="{{ asset('storage/' . $book->sampul) }}" class="card-img-top book-cover" alt="Cover {{ $book->judul }}" style="aspect-ratio: 2/3; object-fit: cover; object-position: center top;">
        @else
            <div class="book-cover-placeholder" style="aspect-ratio: 2/3;">
                <i class="bi bi-book"></i>
                <span>Tanpa Sampul</span>
            </div>
        @endif
        
        <div class="position-absolute top-0 end-0 p-2">
            @if($book->stok > 0)
                <span class="badge badge-status badge-tersedia shadow-sm">Tersedia: {{ $book->stok }}</span>
            @else
                <span class="badge badge-status badge-terlambat shadow-sm">Stok Habis</span>
            @endif
        </div>
    </div>
    
    <div class="card-body d-flex flex-column">
        <div class="book-info-top">
            <span class="book-category">{{ $book->category ? $book->category->nama : 'UMUM' }}</span>
            <h5 class="card-title book-title" title="{{ $book->judul }}">
                {{ $book->judul }}
            </h5>
            <p class="card-text book-author">
                <i class="bi bi-person-fill me-1"></i>{{ $book->pengarang }}
            </p>
        </div>
        
        <div class="book-actions">
            <a href="{{ route('katalog.show', $book->id) }}" class="btn btn-outline-hijau btn-sm rounded-pill fw-medium">Detail</a>
            <form action="{{ route('katalog.pinjam', $book->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-emas btn-sm rounded-pill fw-medium" {{ $book->stok <= 0 ? 'disabled' : '' }}>Pinjam</button>
            </form>
        </div>
    </div>
</div>
