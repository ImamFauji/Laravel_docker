@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Barang</h2>
        <a href="{{ route('barang.create') }}" class="btn btn-primary">+ Tambah Barang</a>
    </div>

    <!-- Search & Filter -->
    <form method="GET" action="{{ route('barang.index') }}" class="row mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari nama barang..."
                value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="kategori_id" class="form-select">
                <option value="">-- Semua Kategori --</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 d-flex">
            <button type="submit" class="btn btn-primary me-2">Filter</button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Gambar</th>
                <th>Kode_barang</th>
                <th>Kategori</th>
                <th>Jumlah stock</th>
                <th>Lokasi</th>
                <th>Tanggal_kategori</th>
                <th width="140">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barang as $items)
                <tr>
                    <td>{{ $loop->iteration + ($barang->currentPage() - 1) * $barang->perPage() }}</td>
                    <td>{{ $items->nama }}</td>
                    <td>
                        @if($items->gambar)
                            <img src="{{ asset('storage/' . $items->gambar) }}" width="80" alt="gambar">
                        @else
                            <img src="{{ asset('img/no-image.png') }}" width="80" alt="no image">
                        @endif
                    </td>
                    <td>{{ $items->kode_barang }}</td>
                    <td>{{ $items->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $items->jumlah_stock }}</td>
                    <td>{{ $items->lokasi }}</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($items->tanggal_kategori)->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('barang.edit', $items) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('barang.destroy', $items) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Hapus barang ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada barang ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $barang->links() }}
@endsection