<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Inventaris Aset' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --navy: #010b74;
            --navy-soft: #1e3c97;
            --yellow: #ffe600;
            --bg-gray: #dcdcdc;
            --card-bg: #ececec;
            --text-dark: #1a1a1a;
            --main-bg-top: #fdfefe;
            --main-bg-bottom: #f4f8ff;
            --sidebar-bg-top: #fbfcfe;
            --sidebar-bg-bottom: #eef4ff;
            --sidebar-text: #22324d;
            --sidebar-muted: #6b7a90;
            --sidebar-border: rgba(148, 163, 184, 0.2);
            --sidebar-accent: #2a5bd7;
        }

        body {
            margin: 0;
            background: var(--bg-gray);
            color: var(--text-dark);
            font-family: "Poppins", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            line-height: 1.45;
            overflow: hidden;
        }

        .app-shell {
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        .app-sidebar {
            width: 250px;
            background: linear-gradient(180deg, var(--sidebar-bg-top) 0%, var(--sidebar-bg-bottom) 100%);
            color: var(--sidebar-text);
            padding: 18px 14px 18px;
            display: flex;
            flex-direction: column;
            box-shadow: inset -1px 0 0 rgba(255, 255, 255, 0.65), 10px 0 30px rgba(15, 23, 42, 0.05);
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            border-right: 1px solid var(--sidebar-border);
        }

        .app-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .app-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .app-sidebar::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.55);
            border-radius: 999px;
        }

        .sidebar-logo {
            width: calc(100% - 72px);
            max-width: 85px;
            aspect-ratio: 5 / 6;
            border-radius: 18px;
            margin: 0 auto 12px;
            overflow: visible;
            background: linear-gradient(180deg, #ffffff 0%, #f4f7fb 100%);
            border: 1px solid rgba(148, 163, 184, 0.22);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--sidebar-text);
            font-weight: 700;
            font-size: 12px;
            box-shadow: 0 14px 28px rgba(148, 163, 184, 0.2);
        }

        .sidebar-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 9px;
            margin-top: 8px;
        }

        .sidebar-nav a,
        .sidebar-nav span {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--sidebar-text);
            padding: 11px 14px;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 600;
            line-height: 1;
            transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
            border: 1px solid transparent;
            background: rgba(255, 255, 255, 0.45);
            width: 100%;
            text-align: left;
            position: relative;
            backdrop-filter: blur(6px);
        }

        .sidebar-nav a:hover {
            background: rgba(42, 91, 215, 0.14);
            color: #1a45a8;
            border-color: rgba(42, 91, 215, 0.12);
            transform: translateX(2px);
        }

        .sidebar-nav .active {
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            color: #16305d;
            border-color: rgba(42, 91, 215, 0.14);
            box-shadow: 0 12px 24px rgba(42, 91, 215, 0.1);
        }

        .sidebar-nav .active::before {
            content: "";
            position: absolute;
            left: 8px;
            top: 50%;
            width: 4px;
            height: 22px;
            border-radius: 999px;
            background: var(--sidebar-accent);
            transform: translateY(-50%);
        }

        .sidebar-nav span {
            opacity: 0.88;
            cursor: default;
            color: var(--sidebar-muted);
        }

        .sidebar-nav i {
            width: 25px;
            text-align: center;
            font-size: 1rem;
            color: var(--sidebar-accent);
        }

        .sidebar-user {
            color: var(--sidebar-muted);
            font-size: 11px;
            margin-top: 2px;
            margin-bottom: 18px;
            text-align: center;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .app-main {
            flex: 1;
            background: linear-gradient(180deg, var(--main-bg-top) 0%, var(--main-bg-bottom) 100%);
            padding: 0 22px 32px;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            position: relative;
        }

        .app-main-navbar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 12px 16px;
            margin: 0 -22px 18px;
            border-radius: 0;
            background: rgba(255, 255, 255, 0.78);
            border-bottom: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.06);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .page-banner {
            background: transparent;
            border-radius: 8px;
            box-shadow: none;
            padding: 16px 20px;
            margin-bottom: 18px;
        }

        .banner-account-btn {
            min-width: 44px;
            height: 44px;
            border-radius: 999px;
            border: 0;
            background: #ffffff;
            color: #1e3c97;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            font-size: 1rem;
            font-weight: 600;
            width: 44px;
        }

        .banner-account-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            border: 1px solid rgba(30, 60, 151, 0.12);
        }

        .banner-account-avatar-fallback {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #eef3ff;
            color: #1e3c97;
            flex-shrink: 0;
        }

        .banner-account-btn i {
            font-size: 1.25rem;
        }

        .banner-account-btn:hover {
            background: #f5f8ff;
            color: #122e84;
        }

        .page-banner h2 {
            margin: 0;
            font-size: 30px;
            font-weight: 800;
            line-height: 1.15;
        }

        .page-banner p {
            margin: 3px 0 0;
            font-size: 16px;
            color: #5f6b7a;
            line-height: 1.4;
            font-weight: 500;
        }

        .card {
            border: 0;
            border-radius: 16px;
        }

        .card.shadow-sm {
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08) !important;
            border: 1px solid #eef2f7;
        }

        .table-responsive {
            border-radius: 16px;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-striped-bg: #fafcff;
            --bs-table-hover-bg: #f5f9ff;
            --bs-table-border-color: #edf2f7;
            margin-bottom: 0;
        }

        .table thead th {
            white-space: nowrap;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            background: #f8fafc;
            border-bottom-width: 1px;
            padding: 14px 16px;
        }

        .table td,
        .table th {
            vertical-align: middle;
            border-color: #edf2f7;
        }

        .table tbody td {
            padding: 15px 16px;
            color: #1e293b;
            font-weight: 500;
        }

        .table tbody tr:last-child td {
            border-bottom: 0;
        }

        .table.table-hover tbody tr {
            transition: background-color 0.2s ease;
        }

        .form-control,
        .form-select {
            border-color: #d5d5d5;
            font-size: 14px;
        }

        .btn {
            font-weight: 600;
            font-size: 13px;
        }

        .alert {
            border: 0;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 991.98px) {
            body {
                overflow: auto;
            }

            .app-shell {
                flex-direction: column;
                min-height: 100vh;
                height: auto;
                overflow: visible;
            }

            .app-sidebar {
                width: 100%;
                height: auto;
                overflow: visible;
            }

            .sidebar-nav a,
            .sidebar-nav span {
                font-size: 17px;
            }

            .page-banner h2 {
                font-size: clamp(1.45rem, 4vw, 2rem);
            }

            .page-banner p {
                font-size: clamp(0.95rem, 2.5vw, 1.2rem);
            }

            .app-main-navbar {
                margin: 0 -22px 10px;
                padding: 10px 12px;
            }

            .app-main {
                padding: 0 22px 20px;
                height: auto;
                overflow: visible;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
@php
    $logoPath = public_path('assets/logo/logobengkalis.png');
    $role = auth()->user()?->role;
    $profilePhoto = auth()->user()?->foto ? \Illuminate\Support\Facades\Storage::url(auth()->user()->foto) : null;
@endphp
<div class="app-shell">
    <aside class="app-sidebar">
        <div class="sidebar-logo">
            @if (file_exists($logoPath))
                <img src="{{ asset('assets/logo/logobengkalis.png') }}" alt="Logo Bengkalis">
            @else
                BK
            @endif
        </div>
        <div class="sidebar-user">Dinas Pendidikan Kabupaten Bengkalis</div>

        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('pegawai.dashboard') ? 'active' : '' }}"><i class="bi bi-grid"></i>Dashboard</a>
            <a href="{{ route('aset.index') }}" class="{{ request()->routeIs('aset.*') ? 'active' : '' }}"><i class="bi bi-card-list"></i>Data Aset</a>
            <a href="{{ route('peminjaman.index') }}" class="{{ request()->routeIs('peminjaman.*') ? 'active' : '' }}"><i class="bi bi-file-earmark-fill"></i>Peminjaman</a>
            <a href="{{ route('pengembalian.index') }}" class="{{ request()->routeIs('pengembalian.*') ? 'active' : '' }}"><i class="bi bi-clipboard2-check-fill"></i>Pengembalian</a>
            @if ($role === 'admin')
                <a href="{{ route('pegawai.index') }}" class="{{ request()->routeIs('pegawai.*') ? 'active' : '' }}"><i class="bi bi-people-fill"></i>Data Pegawai</a>
                <a href="{{ route('kategori-aset.index') }}" class="{{ request()->routeIs('kategori-aset.*') ? 'active' : '' }}"><i class="bi bi-list-ul"></i>Kategori</a>
                <a href="{{ route('lokasi-aset.index') }}" class="{{ request()->routeIs('lokasi-aset.*') ? 'active' : '' }}"><i class="bi bi-boxes"></i>Data Lokasi</a>
                <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}"><i class="bi bi-file-earmark-bar-graph-fill"></i>Laporan</a>
            @endif
            <a href="{{ route('profile.index') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}"><i class="bi bi-person-circle"></i>Profile</a>
        </nav>

    </aside>

    <main class="app-main">
        <nav class="app-main-navbar" aria-label="Top navigation">
            <div class="dropdown">
                <button class="banner-account-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menu akun">
                    @if ($profilePhoto)
                        <img src="{{ $profilePhoto }}" alt="{{ auth()->user()->name ?? 'Pengguna' }}" class="banner-account-avatar">
                    @else
                        <span class="banner-account-avatar-fallback">
                            <i class="bi bi-person-circle"></i>
                        </span>
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li><h6 class="dropdown-header">{{ auth()->user()->name ?? 'Pengguna' }}</h6></li>
                    <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Log Out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <section class="page-banner">
            <div class="page-banner-head">
                <div>
                    <h2>@yield('page_title', 'Dashboard')</h2>
                    <p>@yield('page_subtitle', 'Selamat Datang Kembali')</p>
                </div>
            </div>
        </section>

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
@stack('scripts')
</body>
</html>
