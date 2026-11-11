<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Perpustakaan Sekolah')</title>
    <meta name="description" content="@yield('meta_description', 'Sistem Informasi Perpustakaan Sekolah — Kelola buku, peminjaman, dan anggota dengan mudah.')">

    {{-- Google Fonts (Preconnect & Optimized Load) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo-lentera-icon.png') }}">

    {{-- Tema Perpustakaan (variabel warna) --}}
    <link href="{{ asset('css/tema.css') }}" rel="stylesheet">

    {{-- Inisialisasi Mode Gelap (Cegah kedipan layar / FOUC) --}}
    <script>
        (function() {
            const savedTheme = localStorage.getItem('lentera_theme');
            if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>

    @stack('styles')
</head>
<body>

    {{-- ===== NAVBAR ===== --}}
    <nav class="navbar navbar-expand-lg navbar-perpus sticky-top">
        <div class="container">
            {{-- Kiri: Brand Logo Elegan --}}
            <a class="navbar-brand" href="{{ url('/') }}">
                <span class="brand-logo-wrap">
                    <img src="{{ asset('images/logo-lentera-icon.png') }}" alt="Logo Lentera Pustaka" class="brand-logo-img">
                </span>
                <span class="brand-text-wrap">
                    <span class="brand-title">Lentera</span>
                    <span class="brand-subtitle">Pustaka</span>
                </span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                {{-- Tengah: Kapsul Navigasi Utama (Centered Pill Dock) --}}
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 nav-pill-dock">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="bi bi-house-door me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('katalog*') ? 'active' : '' }}" href="{{ route('katalog.index') }}">
                            <i class="bi bi-compass me-1"></i> Katalog
                        </a>
                    </li>

                    @auth
                        @if(auth()->user()->isAdmin())
                            {{-- Menu Admin --}}
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->is('admin*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-grid-1x2 me-1"></i> Kelola
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.anggota.index') }}">
                                            <i class="bi bi-people me-2"></i> Anggota
                                        </a>
                                    </li>
                                    {{-- Rute berikut milik Nasya & Hayfa --}}
                                    @if(Route::has('admin.buku.index'))
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.buku.index') }}">
                                            <i class="bi bi-book me-2"></i> Buku
                                        </a>
                                    </li>
                                    @endif
                                    @if(Route::has('admin.kategori.index'))
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.kategori.index') }}">
                                            <i class="bi bi-tags me-2"></i> Kategori
                                        </a>
                                    </li>
                                    @endif
                                    @if(Route::has('admin.peminjaman.index'))
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.peminjaman.index') }}">
                                            <i class="bi bi-arrow-left-right me-2"></i> Peminjaman
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                        @else
                            {{-- Menu Anggota --}}
                            @if(Route::has('anggota.peminjaman'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('anggota/peminjaman*') ? 'active' : '' }}" href="{{ route('anggota.peminjaman') }}">
                                    <i class="bi bi-journal-bookmark me-1"></i> Peminjaman Saya
                                </a>
                            </li>
                            @endif
                        @endif
                    @endauth
                </ul>

                {{-- Kanan: Toggle Mode Gelap & Kapsul Profil / Auth --}}
                <ul class="navbar-nav align-items-lg-center gap-lg-2">
                    {{-- Tombol Toggle Mode Gelap --}}
                    <li class="nav-item mb-2 mb-lg-0">
                        <button type="button" class="btn-theme-toggle" id="themeToggleBtn" title="Ganti Mode Gelap / Terang" aria-label="Ganti Mode Gelap / Terang">
                            <i class="bi bi-moon-stars-fill icon-moon"></i>
                            <i class="bi bi-sun-fill icon-sun"></i>
                        </button>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link nav-login-btn" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-emas btn-sm px-3 rounded-pill" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i> Daftar
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle nav-user-pill" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="nav-user-avatar">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="nav-user-info d-none d-lg-flex">
                                    <span class="nav-user-name">{{ Str::limit(auth()->user()->name, 18) }}</span>
                                    <span class="nav-user-role">{{ auth()->user()->isAdmin() ? 'Administrator' : 'Anggota Aktif' }}</span>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="px-3 py-2">
                                    <div class="fw-semibold dropdown-user-name" style="font-size:0.9rem; color: var(--teks);">{{ auth()->user()->name }}</div>
                                    <div class="text-muted" style="font-size:0.78rem;">{{ auth()->user()->email }}</div>
                                    <span class="badge badge-status mt-1 {{ auth()->user()->isAdmin() ? 'badge-admin' : 'badge-anggota' }}">
                                        {{ ucfirst(auth()->user()->role) }}
                                    </span>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                @if(Route::has('profil.edit'))
                                <li>
                                    <a class="dropdown-item" href="{{ route('profil.edit') }}">
                                        <i class="bi bi-person-circle me-2"></i> Profil Saya
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{-- ===== FLASH MESSAGES ===== --}}
    @if(session('success') || session('error') || session('warning') || session('info'))
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-perpus alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-perpus alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('warning'))
            <div class="alert alert-perpus alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{ session('warning') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-perpus alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle-fill"></i>
                <span>{{ session('info') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
    @endif

    {{-- ===== KONTEN UTAMA ===== --}}
    <main>
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    @hasSection('hide_footer')
    @else
    <footer class="footer-perpus">
        <div class="footer-glow-orb footer-glow-1" aria-hidden="true"></div>
        <div class="footer-glow-orb footer-glow-2" aria-hidden="true"></div>

        <div class="container position-relative" style="z-index: 2;">
            <div class="row g-4 g-lg-5 justify-content-between">
                {{-- Kolom 1: Brand & Deskripsi --}}
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand mb-3">
                        <a href="{{ url('/') }}" class="d-inline-flex align-items-center text-decoration-none">
                            <img src="{{ asset('images/logo-lentera-full.png') }}" alt="Lentera Pustaka" class="footer-logo-full">
                        </a>
                    </div>
                    <p class="footer-desc mb-3">
                        Sistem informasi perpustakaan sekolah modern untuk memudahkan penelusuran koleksi buku, sirkulasi peminjaman, dan pengelolaan keanggotaan secara digital.
                    </p>
                    <div class="footer-quote-pill">
                        <i class="bi bi-stars me-1" style="color: var(--gold-400);"></i>
                        <span>"Membuka Jendela Dunia Lewat Literasi"</span>
                    </div>
                </div>

                {{-- Kolom 2: Navigasi / Tautan Cepat --}}
                <div class="col-lg-3 col-md-6 ps-lg-4">
                    <h5 class="footer-heading">Tautan Cepat</h5>
                    <ul class="list-unstyled footer-links mb-0">
                        <li>
                            <a href="{{ url('/') }}">
                                <span class="footer-link-bullet"><i class="bi bi-chevron-right"></i></span>
                                <span>Beranda</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('katalog.index') }}">
                                <span class="footer-link-bullet"><i class="bi bi-chevron-right"></i></span>
                                <span>Katalog Buku</span>
                            </a>
                        </li>
                        @auth
                            @if(!auth()->user()->isAdmin() && Route::has('anggota.peminjaman'))
                            <li>
                                <a href="{{ route('anggota.peminjaman') }}">
                                    <span class="footer-link-bullet"><i class="bi bi-chevron-right"></i></span>
                                    <span>Peminjaman Saya</span>
                                </a>
                            </li>
                            @endif
                            @if(Route::has('profil.edit'))
                            <li>
                                <a href="{{ route('profil.edit') }}">
                                    <span class="footer-link-bullet"><i class="bi bi-chevron-right"></i></span>
                                    <span>Profil Anggota</span>
                                </a>
                            </li>
                            @endif
                        @else
                            <li>
                                <a href="{{ route('login') }}">
                                    <span class="footer-link-bullet"><i class="bi bi-chevron-right"></i></span>
                                    <span>Masuk Akun</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}">
                                    <span class="footer-link-bullet"><i class="bi bi-chevron-right"></i></span>
                                    <span>Pendaftaran Anggota</span>
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>

                {{-- Kolom 3: Informasi Kontak & Jam Layanan --}}
                <div class="col-lg-5 col-md-12">
                    <h5 class="footer-heading">Informasi & Kontak</h5>
                    <ul class="list-unstyled footer-contact-list mb-0">
                        <li>
                            <div class="footer-contact-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div class="footer-contact-info">
                                <span class="footer-contact-label">Alamat Perpustakaan</span>
                                <span class="footer-contact-value">Jl. Laladon Baru No. 17, Ciomas, Bogor, Jawa Barat 16610</span>
                            </div>
                        </li>
                        <li>
                            <div class="footer-contact-icon">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <div class="footer-contact-info">
                                <span class="footer-contact-label">Jam Operasional</span>
                                <span class="footer-contact-value">Senin – Jumat: 07.00 – 15.00 WIB</span>
                            </div>
                        </li>
                        <li>
                            <div class="footer-contact-icon">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div class="footer-contact-info">
                                <span class="footer-contact-label">E-mail</span>
                                <a href="mailto:lenterapustaka@gmail.com" class="footer-contact-value text-decoration-none">lenterapustaka@gmail.com</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <div>
                    &copy; {{ date('Y') }} <strong style="color: var(--gold-300); font-weight: 600;">Lentera Pustaka</strong> — Perpustakaan Sekolah. Hak Cipta Dilindungi.
                </div>
                <div class="footer-bottom-badge">
                    <span class="footer-bottom-icon">
                        <i class="bi bi-mortarboard-fill"></i>
                    </span>
                    <span>Gerakan Literasi Sekolah Digital</span>
                </div>
            </div>
        </div>
    </footer>
    @endif

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Auto-dismiss alerts & Theme Toggle --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.querySelectorAll('.alert-dismissible').forEach(function(alert) {
                    var bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    bsAlert.close();
                });
            }, 5000);

            const themeBtn = document.getElementById('themeToggleBtn');
            if (themeBtn) {
                themeBtn.addEventListener('click', function() {
                    const current = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
                    const next = current === 'dark' ? 'light' : 'dark';
                    document.documentElement.setAttribute('data-theme', next);
                    localStorage.setItem('lentera_theme', next);
                });
            }

            // Ornamen & Partikel Latar Melayang Terstruktur (Beranda, Katalog, Peminjaman Saya)
            if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                const ambientLayout = [
                    { type: 'icon', icon: 'bi-stars', tone: 'gold', left: 3.5, bottom: 78, size: 13, dur: 11, delay: -2 },
                    { type: 'dot',  tone: 'gold',  left: 6.5, bottom: 52, size: 6,  dur: 13, delay: -5 },
                    { type: 'dot',  tone: 'green', left: 2.8, bottom: 24, size: 5,  dur: 10, delay: -1 },
                    { type: 'icon', icon: 'bi-feather', tone: 'green', left: 5.2, bottom: 12, size: 12, dur: 14, delay: -7 },
                    { type: 'dot',  tone: 'gold',  left: 28,  bottom: 86, size: 5,  dur: 12, delay: -4 },
                    { type: 'icon', icon: 'bi-stars', tone: 'gold', left: 48, bottom: 88, size: 12, dur: 15, delay: -9 },
                    { type: 'dot',  tone: 'green', left: 68,  bottom: 85, size: 6,  dur: 11, delay: -3 },
                    { type: 'icon', icon: 'bi-bookmark-star', tone: 'gold', left: 94.5, bottom: 74, size: 13, dur: 13, delay: -6 },
                    { type: 'dot',  tone: 'gold',  left: 96.2, bottom: 48, size: 6, dur: 10, delay: -8 },
                    { type: 'dot',  tone: 'green', left: 93.8, bottom: 22, size: 5, dur: 12, delay: -2 },
                    { type: 'icon', icon: 'bi-stars', tone: 'green', left: 95.5, bottom: 10, size: 12, dur: 14, delay: -5 }
                ];
                document.querySelectorAll('.section-ambient-particles').forEach(function(secContainer) {
                    if (secContainer.children.length > 0) return;
                    ambientLayout.forEach(function(item) {
                        const sp = document.createElement('span');
                        if (item.type === 'icon') {
                            sp.className = 'ambient-floating-icon icon-tone-' + item.tone;
                            sp.innerHTML = '<i class="bi ' + item.icon + '"></i>';
                            sp.style.fontSize = item.size + 'px';
                        } else {
                            sp.className = 'ambient-particle particle-' + item.tone;
                            sp.style.width = item.size + 'px';
                            sp.style.height = item.size + 'px';
                        }
                        sp.style.left = item.left + '%';
                        sp.style.bottom = item.bottom + '%';
                        sp.style.animationDuration = item.dur + 's';
                        sp.style.animationDelay = item.delay + 's';
                        secContainer.appendChild(sp);
                    });
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
