@props(['book'])

<div class="card h-100 shadow-sm border-0 rounded-4 book-card" style="background-color: #fdfbf7;">
    <div class="position-relative">
        @if($book->sampul)
            <img src="{{ asset('storage/' . $book->sampul) }}" class="card-img-top rounded-top-4" alt="Cover {{ $book->judul }}" style="height: 250px; object-fit: cover;">
        @else
            <div class="card-img-top rounded-top-4 d-flex align-items-center justify-content-center bg-light text-muted" style="height: 250px; background-color: #e9ecef;">
                <i class="bi bi-book" style="font-size: 4rem;"></i>
            </div>
        @endif
        
        <div class="position-absolute top-0 end-0 p-2">
            @if($book->stok > 0)
                <span class="badge bg-success rounded-pill px-3 shadow-sm">Tersedia: {{ $book->stok }}</span>
            @else
                <span class="badge bg-danger rounded-pill px-3 shadow-sm">Stok Habis</span>
            @endif
        </div>
    </div>
    
    <div class="card-body d-flex flex-column">
        @if($book->category)
            <span class="text-success small fw-semibold mb-1">{{ $book->category->nama }}</span>
        @endif
        <h5 class="card-title text-truncate" style="font-family: 'Merriweather', serif; font-weight: 700; color: #1a4d2e;" title="{{ $book->judul }}">
            {{ $book->judul }}
        </h5>
        <p class="card-text small text-muted mb-3">{{ $book->pengarang }}</p>
        
        <div class="mt-auto d-flex gap-2">
            <a href="{{ route('katalog.show', $book->id) }}" class="btn btn-outline-success btn-sm flex-grow-1 rounded-pill fw-medium">Detail</a>
            <form action="{{ route('katalog.pinjam', $book->id) }}" method="POST" class="flex-grow-1 d-flex">
                @csrf
                <button type="submit" class="btn btn-success btn-sm flex-grow-1 rounded-pill fw-medium" {{ $book->stok <= 0 ? 'disabled' : '' }}>Pinjam</button>
            </form>
        </div>
    </div>
</div>

<style>
.book-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.book-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
.btn-success {
    background-color: #1a4d2e;
    border-color: #1a4d2e;
}
.btn-success:hover, .btn-success:focus, .btn-success:active {
    background-color: #133a22 !important;
    border-color: #133a22 !important;
}
.text-success {
    color: #1a4d2e !important;
}
.btn-outline-success {
    color: #1a4d2e;
    border-color: #1a4d2e;
}
.btn-outline-success:hover {
    background-color: #1a4d2e;
    color: white;
}
</style>
