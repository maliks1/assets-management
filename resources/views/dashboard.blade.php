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
                                    @foreach($recentTransactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $transaction->product->nama_barang ?? '-' }}</td>
                                            <td>
                                                @if($transaction->tipe_transaksi == 'masuk')
                                                    <span class="badge bg-success">Masuk</span>
                                                @else
                                                    <span class="badge bg-danger">Keluar</span>
                                                @endif
                                            </td>
                                            <td>{{ $transaction->jumlah }}</td>
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
                        <li>Semua aktivitas tercatat di <b>Riwayat Transaksi</b>.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection