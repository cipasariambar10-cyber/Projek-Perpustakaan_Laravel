<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Perpustakaan Sekolah')</title>
    <meta name="description" content="@yield('meta_description', 'Sistem Informasi Perpustakaan Sekolah — Kelola buku, peminjaman, dan anggota dengan mudah.')">

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    {{-- Tema Perpustakaan (variabel warna) --}}
    <link href="{{ asset('css/tema.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>

    {{-- ===== NAVBAR ===== --}}
    <nav class="navbar navbar-expand-lg navbar-perpus sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-lamp-fill brand-icon" style="color: var(--emas);"></i>
                Lentera Pustaka
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="bi bi-house-door me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('katalog*') ? 'active' : '' }}" href="{{ route('katalog.index') }}">
                            <i class="bi bi-search me-1"></i> Katalog
                        </a>
                    </li>

                    @auth
                        @if(auth()->user()->isAdmin())
                            {{-- Menu Admin --}}
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->is('admin*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-gear me-1"></i> Kelola
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

                {{-- Bagian Kanan Navbar --}}
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                            </a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-hijau btn-sm px-3" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i> Daftar
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="d-flex align-items-center justify-content-center rounded-circle"
                                     style="width:32px;height:32px;background:var(--hijau-tua);color:var(--putih);font-size:0.85rem;font-weight:600;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="d-none d-lg-inline">{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="px-3 py-2">
                                    <div class="fw-semibold" style="font-size:0.9rem;">{{ auth()->user()->name }}</div>
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
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5><i class="bi bi-lamp-fill me-2" style="color: var(--emas);"></i>Lentera Pustaka</h5>
                    <p style="font-size: 0.9rem; line-height: 1.8;">
                        Sistem informasi perpustakaan sekolah untuk memudahkan pengelolaan buku,
                        peminjaman, dan keanggotaan.
                    </p>
                </div>
                <div class="col-lg-4">
                    <h5>Tautan Cepat</h5>
                    <ul class="list-unstyled" style="font-size: 0.9rem; line-height: 2;">
                        <li><a href="{{ url('/') }}"><i class="bi bi-chevron-right me-1" style="font-size:0.7rem;"></i> Beranda</a></li>
                        <li><a href="{{ route('katalog.index') }}"><i class="bi bi-chevron-right me-1" style="font-size:0.7rem;"></i> Katalog Buku</a></li>
                        @if(Route::has('info.perpustakaan'))
                        <li><a href="{{ route('info.perpustakaan') }}"><i class="bi bi-chevron-right me-1" style="font-size:0.7rem;"></i> Info Perpustakaan</a></li>
                        @endif
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5>Kontak</h5>
                    <ul class="list-unstyled" style="font-size: 0.9rem; line-height: 2;">
                        <li><i class="bi bi-geo-alt me-2" style="color: var(--emas);"></i> Jl. Laladon No. 1</li>
                        <li><i class="bi bi-clock me-2" style="color: var(--emas);"></i> Senin–Jumat: 07.00–15.00</li>
                        <li><i class="bi bi-envelope me-2" style="color: var(--emas);"></i> perpus@gmail.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} Lentera Pustaka.
            </div>
        </div>
    </footer>
    @endif

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Auto-dismiss alerts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.querySelectorAll('.alert-dismissible').forEach(function(alert) {
                    var bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>

    @stack('scripts')
</body>
</html>
