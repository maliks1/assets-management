@extends('layouts.app')

@section('title', 'Dashboard - Sistem Gudang')

@section('content')
    <style>
        .dashboard-shell .kpi-card {
            border: 1px solid #edf2f7;
            border-left-width: 4px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .dashboard-shell .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(15, 23, 42, 0.08);
        }

        .dashboard-shell .kpi-card.kpi-primary {
            border-left-color: #0d6efd;
        }

        .dashboard-shell .kpi-card.kpi-success {
            border-left-color: #198754;
        }

        .dashboard-shell .kpi-card.kpi-warning {
            border-left-color: #ffc107;
        }

        .dashboard-shell .section-card .card-header {
            border-bottom: 1px solid #eef2f7;
            padding: 0.85rem 1rem;
        }

        .dashboard-shell .summary-list .list-group-item {
            border-left: 0;
            border-right: 0;
            padding-left: 0;
            padding-right: 0;
        }

        .dashboard-shell .summary-list .list-group-item:first-child {
            border-top: 0;
        }

        .dashboard-shell .summary-list .list-group-item:last-child {
            border-bottom: 0;
        }

        .dashboard-shell .activity-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .dashboard-shell .empty-state {
            border: 1px dashed #dbe4ee;
            border-radius: 0.75rem;
            padding: 1.5rem;
            text-align: center;
            color: #64748b;
            background-color: #f8fafc;
        }
    </style>

    <div class="dashboard-shell">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="h3 mb-0">Dashboard</h1>
                <!-- <p class="text-muted mb-0">Pantau stok, nilai aset, dan aktivitas transaksi terbaru dalam satu tampilan.</p> -->
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('transactions.barang-masuk') }}" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-box-arrow-in-down me-1"></i> Barang Masuk
                </a>
                <a href="{{ route('transactions.barang-keluar') }}" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-up me-1"></i> Barang Keluar
                </a>
            </div>
        </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 kpi-card kpi-primary">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total Jenis Barang</div>
                        <h3 class="fw-bold mb-0">{{ $totalProducts }}</h3>
                    </div>
                    <div class="text-primary fs-1">
                        <i class="bi bi-box"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 kpi-card kpi-success">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total Barang</div>
                        <h3 class="fw-bold mb-0">{{ $totalStock }}</h3>
                    </div>
                    <div class="text-success fs-1">
                        <i class="bi bi-archive"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 kpi-card kpi-warning">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total Nilai Barang</div>
                        <h3 class="fw-bold mb-0">
                            Rp {{ number_format($totalStockValue, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="text-warning fs-1">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100 section-card">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-grid me-1"></i> Ringkasan Kategori Aset
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush summary-list mb-0">
                        @foreach($formattedCategorySummary as $category)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div>
                                        <div class="fw-semibold">{{ $category['label'] }}</div>
                                        <small class="text-muted">{{ number_format($category['total_items']) }} jenis barang</small>
                                    </div>
                                    <span class="badge text-bg-light border">Stok: {{ number_format($category['total_stock']) }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100 section-card">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-calendar-check me-1"></i> Transaksi Hari Ini
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="p-3 rounded-3 bg-success-subtle border border-success-subtle h-100">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fw-semibold text-success">Masuk</span>
                                    <i class="bi bi-arrow-down-circle text-success"></i>
                                </div>
                                <div class="small text-muted">{{ number_format($todayTransactions['masuk']['total_transactions']) }} transaksi</div>
                                <div class="h5 mb-0 mt-1">{{ number_format($todayTransactions['masuk']['total_quantity']) }} item</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 rounded-3 bg-danger-subtle border border-danger-subtle h-100">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fw-semibold text-danger">Keluar</span>
                                    <i class="bi bi-arrow-up-circle text-danger"></i>
                                </div>
                                <div class="small text-muted">{{ number_format($todayTransactions['keluar']['total_transactions']) }} transaksi</div>
                                <div class="h5 mb-0 mt-1">{{ number_format($todayTransactions['keluar']['total_quantity']) }} item</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0 section-card">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-clock-history me-1"></i> Aktivitas Terakhir
                </div>
                <div class="card-body">
                    @if($recentTransactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm mb-0 align-middle activity-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Barang</th>
                                        <th>Tipe</th>
                                        <th class="text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTransactions as $transaction)
                                        <tr>
                                            <td>
                                                <i class="bi bi-clock me-1 text-muted"></i>{{ $transaction->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td>{{ $transaction->product->nama_barang ?? '-' }}</td>
                                            <td>
                                                @if($transaction->tipe_transaksi == 'masuk')
                                                    <span class="badge rounded-pill bg-success">Masuk</span>
                                                @else
                                                    <span class="badge rounded-pill bg-danger">Keluar</span>
                                                @endif
                                            </td>
                                            <td class="text-end fw-semibold">{{ number_format($transaction->jumlah) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Belum ada transaksi terbaru.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0 section-card">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-info-circle me-1"></i> Panduan Singkat
                </div>
                <div class="card-body">
                    <ul class="mb-0 ps-3">
                        <li class="mb-2">Gunakan <b>Barang Masuk</b> untuk menambah stok aset.</li>
                        <li class="mb-2">Gunakan <b>Barang Keluar</b> untuk mencatat pengurangan stok.</li>
                        <li class="mb-2">Buka laporan untuk melihat riwayat transaksi dan nilai aset.</li>
                        <li>Periksa ringkasan kategori untuk memantau distribusi aset.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection