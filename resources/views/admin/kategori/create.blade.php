@extends('layouts.admin')

@section('title', 'Tambah Kategori — Lentera Pustaka')

@section('content')
<div class="mb-4">
    <h1 class="page-title">Tambah Kategori</h1>
    <p class="page-subtitle mb-0">Buat kategori buku baru</p>
</div>

<div class="card-perpus" style="max-width:560px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.kategori.store') }}" class="form-perpus">
            @csrf
            @include('admin.kategori._form', ['kategori' => null])
        </form>
    </div>
</div>
@endsection
