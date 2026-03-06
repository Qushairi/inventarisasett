<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Inventaris Aset' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
<div class="d-md-flex min-vh-100">
    <aside class="sidebar bg-dark text-white p-3">
        <div class="mb-4 pb-3 border-bottom border-secondary-subtle">
            <h1 class="h5 mb-1">Sistem Inventaris Aset</h1>
            <small class="text-secondary">Panel Admin</small>
            <div class="mt-2">
                <small class="text-light">Login: {{ auth()->user()->name ?? '-' }}</small>
            </div>
        </div>

        <nav class="nav nav-pills flex-column gap-1">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('pegawai.dashboard') ? 'active' : 'text-white' }}">Dashboard</a>
            <a href="{{ route('aset.index') }}" class="nav-link {{ request()->routeIs('aset.*') ? 'active' : 'text-white' }}">Data Aset</a>
            <a href="{{ route('kategori-aset.index') }}" class="nav-link {{ request()->routeIs('kategori-aset.*') ? 'active' : 'text-white' }}">Kategori</a>
            <a href="{{ route('lokasi-aset.index') }}" class="nav-link {{ request()->routeIs('lokasi-aset.*') ? 'active' : 'text-white' }}">Lokasi</a>
            <a href="{{ route('peminjaman.index') }}" class="nav-link {{ request()->routeIs('peminjaman.*') ? 'active' : 'text-white' }}">Peminjaman</a>
            <a href="{{ route('pengembalian.index') }}" class="nav-link {{ request()->routeIs('pengembalian.*') ? 'active' : 'text-white' }}">Pengembalian</a>
            <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : 'text-white' }}">Laporan</a>
            <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : 'text-white' }}">Profile</a>
        </nav>
    </aside>

    <main class="flex-grow-1 p-3 p-md-4">
        <nav class="navbar navbar-expand navbar-light bg-white rounded-3 border shadow-sm mb-3 px-3">
            <span class="navbar-text text-muted small">Sistem Informasi Inventaris Aset</span>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if (auth()->user()?->foto)
                            <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profile" class="rounded-circle me-1" style="width: 24px; height: 24px; object-fit: cover;">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="me-1" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                                <path d="M14 13c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                            </svg>
                        @endif
                        {{ auth()->user()->name ?? 'User' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <p class="fw-semibold mb-2">Terdapat kesalahan input:</p>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
