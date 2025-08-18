@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Data Kategori</h2>
  <a href="{{ route('kategori.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
</div>

<table class="table table-striped align-middle">
  <thead>
    <tr>
      <th>#</th>
      <th>Nama Kategori</th>
      <th width="140">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($kategori as $category)
    <tr>
      <td>{{ $loop->iteration + ($kategori->currentPage()-1)*$kategori->perPage() }}</td>
      <td>{{ $category->nama_kategori }}</td>
      <td>
        <a href="{{ route('kategori.edit',$category) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('kategori.destroy',$category) }}" method="POST" class="d-inline"
              onsubmit="return confirm('Hapus kategori ini?')">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Hapus</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

{{ $kategori->links() }}
@endsection
