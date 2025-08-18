<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Inventory App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Inventory App</a>
            <div>
                <a href="{{ route('barang.index') }}" class="btn btn-outline-light btn-sm">Barang</a>
                <a href="{{ route('kategori.index') }}" class="btn btn-outline-light btn-sm">Kategori</a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        @yield('content')
    </div>
</body>

</html>