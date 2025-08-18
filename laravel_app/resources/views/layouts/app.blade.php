<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ $title ?? 'Inventory App' }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="{{ route('dashboard') }}">Inventory App</a>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a href="{{ route('barang.index') }}" class="nav-link">Barang</a></li>
      <li class="nav-item"><a href="{{ route('kategori.index') }}" class="nav-link">Kategori</a></li>
      <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST" class="ms-3">
          @csrf
          <button class="btn btn-outline-danger btn-sm">Logout</button>
        </form>
      </li>
    </ul>
  </div>
</nav>

<div class="container py-4">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger mb-3">
      <ul class="mb-0">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif
  @yield('content')
</div>
</body>
</html>
