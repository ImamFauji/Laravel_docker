@extends('layouts.app')

@section('content')
    <h1 class="mb-3">Dashboard</h1>
    ({{ $user->email }})
    <p class="text-muted">Halo, {{ $user->name }}!</p>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Total Barang</h5>
                        <span class="fs-1 fw-bold">{{ $totalBarang }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Total Kategori</h5>
                        <span class="fs-1 fw-bold">{{ $totalKategori }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-4">Barang dengan Stok di bawah 5</h3>
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Kode_barang</th>
                <th>Kategori</th>
                <th>Jumlah stock</th>
                <th>Lokasi</th>
                <th>Tanggal_kategori</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lowStockBarang as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $item->nama }} <br>
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" width="80" alt="gambar">
                        @else
                            <img src="{{ asset('img/no-image.png') }}" width="80" alt="no image">
                        @endif

                    </td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $item->jumlah_stock }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($item->tanggal_kategori)->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Tidak ada barang stok rendah.</td>
                </tr>
            @endforelse
        </tbody>


    </table>
@endsection