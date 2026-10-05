@extends('layouts.admin')

@section('title', 'Ubah Kategori — Lentera Pustaka')

@section('content')
<div class="mb-4">
    <h1 class="page-title">Ubah Kategori</h1>
    <p class="page-subtitle mb-0">Perbarui nama kategori</p>
</div>

<div class="card-perpus" style="max-width:560px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.kategori.update', $kategori) }}" class="form-perpus">
            @csrf
            @method('PUT')
            @include('admin.kategori._form')
        </form>
    </div>
</div>
@endsection
