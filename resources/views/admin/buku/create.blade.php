@extends('layouts.admin')

@section('title', 'Tambah Buku — Lentera Pustaka')

@section('content')
<div class="mb-4">
    <h1 class="page-title">Tambah Buku</h1>
    <p class="page-subtitle mb-0">Masukkan data buku baru</p>
</div>

<div class="card-perpus">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.buku.store') }}" class="form-perpus">
            @csrf
            @include('admin.buku._form')
        </form>
    </div>
</div>
@endsection
