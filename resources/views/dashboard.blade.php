@extends('layouts.app')

@section('title', 'Dashboard - Sistem Gudang')

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total Jenis Produk</div>
                        <h3 class="fw-bold mb-0">{{ $totalProducts }}</h3>
                    </div>
                    <div class="text-primary fs-1">
                        <i class="bi bi-box"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total Produk</div>
                        <h3 class="fw-bold mb-0">{{ $totalStock }}</h3>
                    </div>
                    <div class="text-success fs-1">
                        <i class="bi bi-archive"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total Nilai Produk</div>
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

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                    Barang Hampir Habis
                </h5>
                <span class="badge bg-danger">
                    {{ $lowStockProducts->count() }}
                </span>
            </div>

            @if($lowStockProducts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Stok</th>
                                <th>Minimum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockProducts as $product)
                                <tr>
                                    <td>{{ $product->kode_barang }}</td>
                                    <td>{{ $product->nama_barang }}</td>
                                    <td>
                                        <span class="badge bg-danger">
                                            {{ $product->stok_saat_ini }}
                                        </span>
                                    </td>
                                    <td>{{ $product->stok_minimum }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-muted text-center py-3">
                    <i class="bi bi-check-circle fs-4 text-success"></i><br>
                    Semua stok aman
                </div>
            @endif
        </div>
    </div>


    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-clock-history"></i> Aktivitas Terakhir
                </div>
                <div class="card-body">
                    @if($recentTransactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Barang</th>
                                        <th>Tipe</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTransactions as $trx)
                                        <tr>
                                            <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $trx->product->nama_barang ?? '-' }}</td>
                                            <td>
                                                @if($trx->tipe_transaksi == 'masuk')
                                                    <span class="badge bg-success">Masuk</span>
                                                @else
                                                    <span class="badge bg-danger">Keluar</span>
                                                @endif
                                            </td>
                                            <td>{{ $trx->jumlah }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-muted">Belum ada transaksi.</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-light">
                    <i class="bi bi-info-circle"></i> Info
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Gunakan menu <b>Barang Masuk</b> untuk menambah stok.</li>
                        <li>Gunakan menu <b>Barang Keluar</b> untuk mengurangi stok.</li>
                        <li>Periksa <b>Barang Akan Habis</b> untuk mencegah kehabisan stok.</li>
                        <li>Semua aktivitas tercatat di <b>Riwayat Transaksi</b>.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection