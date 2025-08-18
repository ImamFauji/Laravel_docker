@extends('layouts.app')

@section('content')
    <h2 class="mb-3">Edit Barang</h2>
    <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="col-md-4">
            <label class="form-label">Gambar</label>
            <input type="file" name="picture" class="form-control">
            <img src="{{ asset('storage/' . ($barang->gambar ?? 'img/no-image.png')) }}" alt="" width="100" class="mt-2">
        </div>
        <div class="col-md-4">
            <label class="form-label">Kode_barang</label>
            <input name="kode_barang" class="form-control" value="{{ old('kode_barang', $barang->kode_barang) }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Nama</label>
            <input name="nama" class="form-control" value="{{ old('nama', $barang->nama) }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Kategori</label>
            <select name="kategori_id" class="form-select" required>
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}" @selected(old('kategori_id', $barang->kategori_id) == $k->id)>
                        {{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Jumlah stock</label>
            <input type="number" min="0" name="jumlah_stock" class="form-control"
                value="{{ old('jumlah_stock', $barang->jumlah_stock) }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Lokasi</label>
            <input name="lokasi" class="form-control" value="{{ old('lokasi', $barang->lokasi) }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal_kategori</label>
            <input type="date" name="tanggal_kategori" class="form-control"
                value="{{ old('tanggal_kategori', $barang->tanggal_kategori) }}" required>
        </div>
        <div class="col-12">
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
            <button class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection