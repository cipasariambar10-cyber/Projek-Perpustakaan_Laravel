@extends('layouts.admin')

@section('title', 'Ubah Buku — Lentera Pustaka')

@section('content')
<div class="mb-4">
    <h1 class="page-title">Ubah Buku</h1>
    <p class="page-subtitle mb-0">{{ $buku->judul }}</p>
</div>

<div class="card-perpus">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.buku.update', $buku) }}" class="form-perpus">
            @csrf
            @method('PUT')
            @include('admin.buku._form')
        </form>
    </div>
</div>
@endsection
