@extends('layouts.app')

@section('title', 'Perpustakaan Sekolah — Beranda')
@section('meta_description', 'Selamat datang di Perpustakaan Sekolah. Temukan koleksi buku terbaik, pinjam buku dengan mudah, dan jelajahi dunia literasi.')

@section('content')

{{-- ===== HERO SECTION ===== --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="fade-in-up">
                    Jelajahi Dunia<br>
                    <span class="hero-accent">Literasi</span> Tanpa Batas
                </h1>
                <p class="fade-in-up mb-4">
                    Temukan ribuan koleksi buku, pinjam dengan mudah, dan kembangkan
                    wawasanmu bersama Perpustakaan Sekolah.
                </p>
                <div class="fade-in-up mt-4">
                    <form action="{{ route('katalog.index') }}" method="GET" class="d-flex" style="max-width: 500px; background: white; padding: 5px; border-radius: 50px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        <input type="text" name="q" class="form-control border-0 shadow-none px-4" placeholder="Cari judul buku, pengarang, atau kategori..." style="border-radius: 50px; font-size: 0.95rem;">
                        <button type="submit" class="btn btn-emas px-4 py-2" style="border-radius: 50px;">
                            <i class="bi bi-search me-1"></i> Cari
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-flex justify-content-center">
                <div class="text-center" style="opacity: 0.15; font-size: 12rem; line-height: 1;">
                    <i class="bi bi-book-half"></i>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== STATISTIK SINGKAT ===== --}}
<section class="py-4" style="background: var(--putih); border-bottom: 1px solid var(--garis);">
    <div class="container">
        <div class="row g-3 text-center">
            <div class="col-6 col-md-3">
                <div class="py-2">
                    <div style="font-family: var(--font-judul); font-size: 1.8rem; font-weight: 900; color: var(--hijau-tua);">
                        {{ number_format($totalBuku) }}
                    </div>
                    <div style="font-size: 0.85rem; color: var(--teks-lembut);">Koleksi Buku</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="py-2">
                    <div style="font-family: var(--font-judul); font-size: 1.8rem; font-weight: 900; color: var(--hijau-tua);">
                        {{ number_format($totalAnggota) }}
                    </div>
                    <div style="font-size: 0.85rem; color: var(--teks-lembut);">Anggota Aktif</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="py-2">
                    <div style="font-family: var(--font-judul); font-size: 1.8rem; font-weight: 900; color: var(--emas);">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div id="realtime-clock" style="font-size: 0.85rem; color: var(--teks-lembut); font-weight: bold;">Loading... WIB</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="py-2">
                    <div style="font-family: var(--font-judul); font-size: 1.8rem; font-weight: 900; color: var(--emas);">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div id="realtime-date" style="font-size: 0.85rem; color: var(--teks-lembut); font-weight: bold;">Loading...</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== BUKU TERBARU ===== --}}
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h2 class="section-title">Buku Terbaru</h2>
                <p class="section-subtitle mb-0">Koleksi terbaru yang baru ditambahkan</p>
            </div>
            <a href="{{ route('katalog.index') }}" class="btn btn-outline-hijau btn-sm mt-2">
                Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        @if($bukuTerbaru->count() > 0)
            <div class="row g-4">
                @foreach($bukuTerbaru as $buku)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="book-card">
                        @if(!empty($buku->sampul))
                            <img src="{{ asset('storage/' . $buku->sampul) }}" alt="{{ $buku->judul }}" class="book-cover">
                        @else
                            <div class="book-cover-placeholder">
                                <i class="bi bi-book"></i>
                                <span>Tanpa Sampul</span>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="book-title">{{ $buku->judul }}</div>
                            <div class="book-author">
                                <i class="bi bi-person-fill me-1"></i> {{ $buku->pengarang }}
                            </div>
                            <div class="book-meta">
                                <span><i class="bi bi-calendar3 me-1"></i> {{ $buku->tahun_terbit ?? '-' }}</span>
                                <span><i class="bi bi-box me-1"></i> Stok: {{ $buku->stok ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-book"></i>
                <h5>Belum Ada Buku</h5>
                <p>Koleksi buku akan segera tersedia. Nantikan ya!</p>
            </div>
        @endif
    </div>
</section>

{{-- ===== BUKU POPULER ===== --}}
@if($bukuPopuler->count() > 0)
<section class="py-5" style="background: var(--putih);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h2 class="section-title">Buku Populer</h2>
                <p class="section-subtitle mb-0">Paling banyak dipinjam oleh anggota</p>
            </div>
            <a href="{{ route('katalog.index') }}" class="btn btn-outline-hijau btn-sm mt-2">
                Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($bukuPopuler as $buku)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="book-card">
                    @if(!empty($buku->sampul))
                        <img src="{{ asset('storage/' . $buku->sampul) }}" alt="{{ $buku->judul }}" class="book-cover">
                    @else
                        <div class="book-cover-placeholder">
                            <i class="bi bi-book"></i>
                            <span>Tanpa Sampul</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="book-title">{{ $buku->judul }}</div>
                        <div class="book-author">
                            <i class="bi bi-person-fill me-1"></i> {{ $buku->pengarang }}
                        </div>
                        <div class="book-meta">
                            <span><i class="bi bi-calendar3 me-1"></i> {{ $buku->tahun_terbit ?? '-' }}</span>
                            <span><i class="bi bi-box me-1"></i> Stok: {{ $buku->stok ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== CTA SECTION ===== --}}
@guest
<section class="py-5" style="background: linear-gradient(135deg, var(--hijau-tua), var(--hijau-tua-light));">
    <div class="container text-center">
        <h2 style="font-family: var(--font-judul); color: var(--putih); font-size: 2rem; margin-bottom: 1rem;">
            Siap Menjelajahi Perpustakaan?
        </h2>
        <p style="color: rgba(255,255,255,0.8); font-size: 1.05rem; max-width: 500px; margin: 0 auto 1.5rem;">
            Daftar sekarang dan mulai pinjam buku favoritmu. Gratis dan mudah!
        </p>
        <a href="{{ route('register') }}" class="btn btn-emas btn-lg px-5">
            <i class="bi bi-person-plus me-2"></i> Daftar Sekarang
        </a>
    </div>
</section>
@endguest

@endsection

@push('scripts')
<script>
    function updateClock() {
        const now = new Date();
        // Set to WIB (UTC+7)
        const offset = 7;
        const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
        const wibTime = new Date(utc + (3600000 * offset));
        
        let hours = wibTime.getHours().toString().padStart(2, '0');
        let minutes = wibTime.getMinutes().toString().padStart(2, '0');
        let seconds = wibTime.getSeconds().toString().padStart(2, '0');
        
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        let dayName = days[wibTime.getDay()];
        let date = wibTime.getDate();
        let monthName = months[wibTime.getMonth()];
        let year = wibTime.getFullYear();
        
        document.getElementById('realtime-clock').textContent = hours + '.' + minutes + '.' + seconds + ' WIB';
        document.getElementById('realtime-date').textContent = dayName + ', ' + date + ' ' + monthName + ' ' + year;
    }
    
    // Update immediately and then every second
    updateClock();
    setInterval(updateClock, 1000);
</script>
@endpush
