@extends('layouts.app')

@section('content')
<h2 class="mb-3">Tambah Kategori</h2>
<form action="{{ route('kategori.store') }}" method="POST" class="row g-3">
  @csrf
  <div class="col-md-6">
    <label class="form-label">Nama Kategori</label>
    <input name="nama_kategori" class="form-control" value="{{ old('nama_kategori') }}" required>
  </div>
  <div class="col-12">
    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
    <button class="btn btn-primary">Simpan</button>
  </div>
</form>
@endsection
