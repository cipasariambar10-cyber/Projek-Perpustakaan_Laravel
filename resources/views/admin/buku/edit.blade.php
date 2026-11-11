@extends('layouts.admin')

@section('title', 'Ubah Buku — Lentera Pustaka')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.buku.index') }}" class="btn-back-nav mb-2">
        <span class="back-nav-icon"><i class="bi bi-arrow-left"></i></span>
        <span>Kembali ke Daftar Buku</span>
    </a>
    <h1 class="page-title mt-2">Ubah Buku</h1>
    <p class="page-subtitle mb-0">{{ $buku->judul }}</p>
</div>

<div class="card-perpus">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.buku.update', $buku) }}" class="form-perpus" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.buku._form')
        </form>
    </div>
</div>
@endsection
