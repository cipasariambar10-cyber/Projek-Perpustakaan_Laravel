@extends('layouts.app')

@section('title', 'Perpustakaan Sekolah — Beranda')
@section('meta_description', 'Selamat datang di Perpustakaan Sekolah. Temukan koleksi buku terbaik, pinjam buku dengan mudah, dan jelajahi dunia literasi.')

@section('content')

{{-- ===== HERO SECTION ===== --}}
<section class="hero-section">
    {{-- 4 Lingkaran Blur Mesh Gradient --}}
    <div class="hero-blobs" aria-hidden="true">
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <div class="hero-blob hero-blob-3"></div>
        <div class="hero-blob hero-blob-4"></div>
    </div>

    {{-- Bentuk Geometris Samar Berputar di Sudut --}}
    <div class="hero-geom-shapes" aria-hidden="true">
        <div class="hero-ring hero-ring-1"></div>
        <div class="hero-ring hero-ring-2"></div>
    </div>

    {{-- Berkas Cahaya Lembut (Light Rays) --}}
    <div class="hero-light-rays" aria-hidden="true">
        <div class="hero-ray hero-ray-1"></div>
        <div class="hero-ray hero-ray-2"></div>
        <div class="hero-ray hero-ray-3"></div>
    </div>

    {{-- Tekstur Grain / Noise --}}
    <div class="hero-noise" aria-hidden="true"></div>

    {{-- Partikel Emas Melayang (Kunang-kunang Lentera) --}}
    <div class="hero-particles" id="hero-particles" aria-hidden="true"></div>

    <div class="container position-relative" style="z-index: 5;">
        <div class="row justify-content-center text-center">
            <div class="col-lg-9 col-xl-8">
                {{-- B.1: Lencana Kecil di Atas Judul --}}
                <div class="hero-badge-wrapper mb-3">
                    <span class="hero-badge">
                        <span class="badge-pulse-dot"></span>
                        Perpustakaan Sekolah
                    </span>
                </div>

                {{-- B.2 & B.3: Judul Muncul Per Kata & Kilau Emas pada "Literasi" --}}
                <h1 class="hero-title mb-3">
                    <span class="hero-word" style="--delay: 0.05s;">Jelajahi</span>
                    <span class="hero-word" style="--delay: 0.15s;">Dunia</span><br>
                    <span class="hero-word hero-accent-shimmer" style="--delay: 0.25s;">Literasi</span>
                    <span class="hero-word" style="--delay: 0.35s;">Tanpa</span>
                    <span class="hero-word" style="--delay: 0.45s;">Batas</span>
                </h1>

                {{-- B.4: Paragraf Deskripsi --}}
                <p class="hero-desc mb-4 mx-auto" style="max-width: 640px;">
                    Temukan ribuan koleksi buku, pinjam dengan mudah, dan kembangkan
                    wawasanmu bersama Perpustakaan Sekolah.
                </p>

                {{-- B.5: Kolom Pencarian dengan Interaksi Fokus & Sweep Hover --}}
                <div class="hero-search-wrapper mt-4 d-flex justify-content-center">
                    <form action="{{ route('katalog.index') }}" method="GET" class="d-flex w-100 search-hero-box" style="max-width: 550px; background: rgba(253, 251, 246, 0.95); backdrop-filter: blur(14px); padding: 6px; border-radius: var(--radius-pill); box-shadow: 0 12px 36px rgba(13, 28, 23, 0.28); border: 1.5px solid rgba(240, 198, 116, 0.45);">
                        <input type="text" name="q" class="form-control border-0 shadow-none px-4" placeholder="Cari judul buku, pengarang, atau kategori..." style="border-radius: var(--radius-pill); font-size: 0.95rem; background: transparent; color: var(--green-900);">
                        <button type="submit" class="btn btn-emas btn-emas-search px-4 py-2" style="border-radius: var(--radius-pill);">
                            <i class="bi bi-search me-1"></i> Cari
                        </button>
                    </form>
                </div>

                {{-- B.7: Indikator Scroll Kecil di Bawah Hero --}}
                <div class="hero-scroll-indicator mt-4" aria-hidden="true">
                    <a href="#section-stats" class="scroll-down-link" title="Gulir ke Bawah">
                        <i class="bi bi-chevron-compact-down scroll-arrow"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== STATISTIK SINGKAT ===== --}}
<section id="section-stats" class="py-4 stat-section" style="background: var(--cream-100); border-bottom: 1px solid var(--cream-200); box-shadow: inset 0 -4px 12px rgba(31,64,55,0.03);">
    <div class="container">
        <div class="row g-3 text-center">
            <div class="col-6 col-md-3">
                <div class="py-2">
                    <div class="stat-count-up" data-target="{{ $totalBuku }}" style="font-family: var(--font-judul); font-size: 1.8rem; font-weight: 900; color: var(--hijau-tua);">
                        {{ number_format($totalBuku) }}
                    </div>
                    <div style="font-size: 0.85rem; color: var(--teks-lembut);">Koleksi Buku</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="py-2">
                    <div class="stat-count-up" data-target="{{ $totalAnggota }}" style="font-family: var(--font-judul); font-size: 1.8rem; font-weight: 900; color: var(--hijau-tua);">
                        {{ number_format($totalAnggota) }}
                    </div>
                    <div style="font-size: 0.85rem; color: var(--teks-lembut);">Anggota Aktif</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="py-2">
                    <div style="font-family: var(--font-judul); font-size: 1.8rem; font-weight: 900; color: var(--emas);">
                        <i class="bi bi-clock stat-icon-wobble"></i>
                    </div>
                    <div id="realtime-clock" style="font-size: 0.85rem; color: var(--teks-lembut); font-weight: bold;">Loading... WIB</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="py-2">
                    <div style="font-family: var(--font-judul); font-size: 1.8rem; font-weight: 900; color: var(--emas);">
                        <i class="bi bi-calendar-check stat-icon-wobble"></i>
                    </div>
                    <div id="realtime-date" style="font-size: 0.85rem; color: var(--teks-lembut); font-weight: bold;">Loading...</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Lengkungan Pemisah Halus: Statistik ke Buku Terbaru --}}
<div class="section-curve-divider" aria-hidden="true" style="background: var(--cream-100); margin-bottom: -1px;">
    <svg viewBox="0 0 1440 40" fill="none" preserveAspectRatio="none">
        <path d="M0,0 C360,32 1080,32 1440,0 L1440,40 L0,40 Z" fill="#FDFBF6"></path>
    </svg>
</div>

{{-- ===== BUKU TERBARU ===== --}}
<section class="py-5 section-buku-terbaru position-relative">
    {{-- Glow Blur Tipis --}}
    <div class="section-glow-orbs" aria-hidden="true">
        <div class="section-glow-1"></div>
        <div class="section-glow-2"></div>
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                {{-- Lencana Kecil di Atas Judul --}}
                <div class="section-badge-wrapper">
                    <span class="section-badge">
                        <span class="badge-dot-emas"></span>
                        Koleksi Baru
                    </span>
                </div>
                <h2 class="section-title">Buku Terbaru</h2>
                <p class="section-subtitle mb-0">Koleksi terbaru yang baru ditambahkan</p>
            </div>
            <a href="{{ route('katalog.index') }}" class="btn btn-outline-hijau btn-sm mt-3">
                Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        @if($bukuTerbaru->count() > 0)
            <div class="row books-grid-row">
                @foreach($bukuTerbaru as $buku)
                <div class="col">
                    <div class="book-card">
                        <div class="book-cover-container">
                            @if(!empty($buku->sampul))
                                <img src="{{ asset('storage/' . $buku->sampul) }}" alt="{{ $buku->judul }}" class="book-cover">
                            @else
                                <div class="book-cover-placeholder">
                                    <i class="bi bi-book"></i>
                                    <span>Tanpa Sampul</span>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="book-info-top">
                                <div class="book-title">{{ $buku->judul }}</div>
                                <div class="book-author">
                                    <i class="bi bi-person-fill me-1"></i> {{ $buku->pengarang }}
                                </div>
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

{{-- Lengkungan Pemisah Halus: Buku Terbaru ke Buku Populer --}}
<div class="section-curve-divider" aria-hidden="true" style="background: #F6EEDC; margin-bottom: -1px; margin-top: -1px;">
    <svg viewBox="0 0 1440 40" fill="none" preserveAspectRatio="none">
        <path d="M0,0 C480,36 960,36 1440,0 L1440,40 L0,40 Z" fill="#F4F7F2"></path>
    </svg>
</div>

{{-- ===== BUKU POPULER ===== --}}
@if($bukuPopuler->count() > 0)
<section class="py-5 section-buku-populer position-relative">
    {{-- Glow Blur Tipis --}}
    <div class="section-glow-orbs" aria-hidden="true">
        <div class="section-glow-1"></div>
        <div class="section-glow-2"></div>
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                {{-- Lencana Kecil di Atas Judul --}}
                <div class="section-badge-wrapper">
                    <span class="section-badge">
                        <span class="badge-dot-emas"></span>
                        Favorit Anggota
                    </span>
                </div>
                <h2 class="section-title">Buku Populer</h2>
                <p class="section-subtitle mb-0">Paling banyak dipinjam oleh anggota</p>
            </div>
            <a href="{{ route('katalog.index') }}" class="btn btn-outline-hijau btn-sm mt-3">
                Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row books-grid-row">
            @foreach($bukuPopuler as $buku)
            <div class="col">
                <div class="book-card">
                    <div class="book-cover-container">
                        @if(!empty($buku->sampul))
                            <img src="{{ asset('storage/' . $buku->sampul) }}" alt="{{ $buku->judul }}" class="book-cover">
                        @else
                            <div class="book-cover-placeholder">
                                <i class="bi bi-book"></i>
                                <span>Tanpa Sampul</span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="book-info-top">
                            <div class="book-title">{{ $buku->judul }}</div>
                            <div class="book-author">
                                <i class="bi bi-person-fill me-1"></i> {{ $buku->pengarang }}
                            </div>
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

{{-- Lengkungan Pemisah Halus: Buku Populer ke Section Selanjutnya --}}
<div class="section-curve-divider" aria-hidden="true" style="background: #E9F0EA; margin-bottom: -1px; margin-top: -1px;">
    <svg viewBox="0 0 1440 36" fill="none" preserveAspectRatio="none">
        <path d="M0,0 C360,28 1080,28 1440,0 L1440,36 L0,36 Z" fill="var(--cream-50)"></path>
    </svg>
</div>
@endif

{{-- ===== CTA SECTION ===== --}}
@guest
<section class="py-5">
    <div class="container">
        <div class="cta-section text-center p-5 reveal-on-scroll">
            <h2 style="font-family: var(--font-judul); color: var(--cream-50); font-size: 2.2rem; margin-bottom: 1rem; font-weight: 800;">
                Siap Menjelajahi Perpustakaan?
            </h2>
            <p style="color: rgba(253, 251, 246, 0.9); font-size: 1.1rem; max-width: 540px; margin: 0 auto 1.75rem;">
                Daftar sekarang dan mulai pinjam buku favoritmu. Gratis, praktis, dan mudah!
            </p>
            <a href="{{ route('register') }}" class="btn btn-emas btn-lg px-5 py-3" style="font-size: 1rem;">
                <i class="bi bi-person-plus me-2"></i> Daftar Sekarang
            </a>
        </div>
    </div>
</section>
@endguest

@endsection

@push('scripts')
<script>
    // 1. Jam Real-time WIB
    function updateClock() {
        const now = new Date();
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
        
        const clockEl = document.getElementById('realtime-clock');
        const dateEl = document.getElementById('realtime-date');
        if (clockEl) clockEl.textContent = hours + '.' + minutes + '.' + seconds + ' WIB';
        if (dateEl) dateEl.textContent = dayName + ', ' + date + ' ' + monthName + ' ' + year;
    }
    updateClock();
    setInterval(updateClock, 1000);

    // 2. A.3 - Inisialisasi Partikel Emas Melayang (28 Partikel: 2-6px, Gerak Goyang / Drift & Berkedip Lentera)
    (function initHeroParticles() {
        const container = document.getElementById('hero-particles');
        if (!container || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        
        const particleCount = 28;
        for (let i = 0; i < particleCount; i++) {
            const p = document.createElement('span');
            p.className = 'hero-particle';
            const size = Math.floor(Math.random() * 5) + 2; // 2px - 6px
            const left = (Math.random() * 100).toFixed(1);
            const bottom = (Math.random() * 40).toFixed(1);
            const duration = (Math.random() * 12 + 12).toFixed(1); // 12s - 24s
            const delay = (Math.random() * 10).toFixed(1); // 0s - 10s
            
            p.style.cssText = `
                left: ${left}%;
                bottom: ${bottom}%;
                width: ${size}px;
                height: ${size}px;
                animation-duration: ${duration}s;
                animation-delay: ${delay}s;
            `;
            container.appendChild(p);
        }
    })();

    // 3. Count-Up Animasi Angka Statistik (1.5 detik, Easing Keluar)
    function animateCountUp(el, start, end, duration) {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || end === 0) {
            el.textContent = new Intl.NumberFormat('id-ID').format(end);
            return;
        }
        let startTime = null;
        const step = (timestamp) => {
            if (!startTime) startTime = timestamp;
            const progress = Math.min((timestamp - startTime) / duration, 1);
            const ease = 1 - Math.pow(1 - progress, 3); // easeOutCubic
            const current = Math.floor(ease * (end - start) + start);
            el.textContent = new Intl.NumberFormat('id-ID').format(current);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                el.textContent = new Intl.NumberFormat('id-ID').format(end);
            }
        };
        window.requestAnimationFrame(step);
    }

    // 4. C - Scroll Reveal Menggunakan IntersectionObserver
    document.addEventListener('DOMContentLoaded', function() {
        const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        
        // Count-Up Statistik & Animasi Ikon Jam/Kalender saat Masuk Viewport
        const statSection = document.getElementById('section-stats');
        const statElements = document.querySelectorAll('.stat-count-up');
        
        if (statSection) {
            if (prefersReduced || !('IntersectionObserver' in window)) {
                statSection.classList.add('is-revealed');
                statElements.forEach(el => {
                    const target = parseInt(el.getAttribute('data-target'), 10) || 0;
                    el.textContent = new Intl.NumberFormat('id-ID').format(target);
                });
            } else {
                const statObserver = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-revealed');
                            statElements.forEach(el => {
                                const target = parseInt(el.getAttribute('data-target'), 10) || 0;
                                animateCountUp(el, 0, target, 1500);
                            });
                            obs.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.25 });
                statObserver.observe(statSection);
            }
        }

        if (prefersReduced || !('IntersectionObserver' in window)) {
            document.querySelectorAll('.reveal-on-scroll, .section-title').forEach(el => el.classList.add('is-revealed'));
            return;
        }

        // IntersectionObserver untuk Judul Section (Garis Emas Memanjang) & Elemen Reveal
        const revealObserver = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        // Observasi Judul Section (untuk garis emas ::after) tanpa menyembunyikan teks
        document.querySelectorAll('.section-title').forEach(el => {
            revealObserver.observe(el);
        });

        // Observasi Banner CTA, Footer, dan Elemen Animasi Lainnya
        document.querySelectorAll('.cta-section, .footer-perpus, .footer-custom').forEach(el => {
            if (!el.classList.contains('reveal-on-scroll')) {
                el.classList.add('reveal-on-scroll');
            }
            revealObserver.observe(el);
        });

        // C.2 - Observasi Kartu Buku dengan Stagger per Baris (0.08s)
        document.querySelectorAll('.books-grid-row').forEach(row => {
            const cols = row.querySelectorAll('.col');
            if (cols.length > 0) {
                cols.forEach((col, idx) => {
                    col.classList.add('reveal-on-scroll');
                    col.style.transitionDelay = `${(idx % 5) * 0.08}s`;
                    revealObserver.observe(col);
                });
            }
        });

        // Fallback: Pastikan judul Buku Populer dan seluruh konten selalu tampil jika scroll observer tidak terpicu
        setTimeout(() => {
            document.querySelectorAll('.section-title').forEach(el => el.classList.add('is-revealed'));
            document.querySelectorAll('.reveal-on-scroll:not(.is-revealed)').forEach(el => el.classList.add('is-revealed'));
        }, 1200);
    });
</script>
@endpush
