{{-- Sidebar navigasi admin --}}
<div class="col-lg-2 sidebar-perpus d-none d-lg-block">
    <div class="sidebar-heading">Menu Utama</div>
    <nav class="nav flex-column">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a class="nav-link {{ request()->routeIs('admin.anggota.*') ? 'active' : '' }}"
           href="{{ route('admin.anggota.index') }}">
            <i class="bi bi-people"></i> Anggota
        </a>
    </nav>

    {{-- Menu Nasya (Buku & Kategori) --}}
    @if(Route::has('admin.buku.index') || Route::has('admin.kategori.index'))
    <div class="sidebar-heading mt-3">Koleksi</div>
    <nav class="nav flex-column">
        @if(Route::has('admin.buku.index'))
        <a class="nav-link {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}"
           href="{{ route('admin.buku.index') }}">
            <i class="bi bi-book"></i> Buku
        </a>
        @endif
        @if(Route::has('admin.kategori.index'))
        <a class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}"
           href="{{ route('admin.kategori.index') }}">
            <i class="bi bi-tags"></i> Kategori
        </a>
        @endif
    </nav>
    @endif

    {{-- Menu Hayfa (Peminjaman) --}}
    @if(Route::has('admin.peminjaman.index'))
    <div class="sidebar-heading mt-3">Sirkulasi</div>
    <nav class="nav flex-column">
        <a class="nav-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}"
           href="{{ route('admin.peminjaman.index') }}">
            <i class="bi bi-arrow-left-right"></i> Peminjaman
        </a>
    </nav>
    @endif
</div>
