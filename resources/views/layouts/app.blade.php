<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Gudang')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .navbar-nav .nav-link.active {
            background-color: rgba(255, 255, 255, 0.25) !important;
            border-radius: 0.375rem;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 0.375rem;
            transition: all 0.2s ease;
        }

        .navbar-nav .nav-link {
            transition: all 0.2s ease;
            margin: 0 2px;
        }

        .card {
            border-radius: 12px;
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #f0f0f0;
            font-weight: 600;
        }

        .navbar-brand {
            font-weight: 600;
            letter-spacing: 0.5px;
        }
    </style>
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #1f2937;">

        <div class="container">

            <a class="navbar-brand" href="{{ route('dashboard') }}" style="font-size: 1.5rem; font-weight: 700; letter-spacing: 1px;">
                Sistem Manajemen Aset
            </a>

            <div class="navbar-collapse">
                <div class="mx-auto">
                    <ul class="navbar-nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                href="{{ route('dashboard') }}">
                                <i class="bi bi-house"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('products.index') || request()->routeIs('products.show') || request()->routeIs('products.edit') ? 'active' : '' }}"
                                href="{{ route('products.index') }}">
                                <i class="bi bi-box"></i> Data Aset
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('transactions.*') || request()->routeIs('products.create') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-arrow-repeat"></i> Transaksi
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item {{ request()->routeIs('products.create') ? 'active' : '' }}" href="{{ route('products.create') }}">
                                        <i class="bi bi-box-arrow-in-down"></i> Barang Masuk
                                    </a></li>
                                <li><a class="dropdown-item" href="{{ route('transactions.barang-keluar') }}">
                                        <i class="bi bi-box-arrow-up"></i> Barang Keluar
                                    </a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-file-earmark-text"></i> Laporan
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('reports.transaction-history') }}">
                                        <i class="bi bi-clock-history"></i> Riwayat Transaksi
                                    </a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.asset-value') }}">
                                        <i class="bi bi-graph-up"></i> Nilai Aset
                                    </a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> Halo, {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <main class="py-5">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>