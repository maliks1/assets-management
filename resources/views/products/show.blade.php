@extends('layouts.app')

@section('title', 'Detail Barang - Sistem Gudang')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Detail Barang</h1>
            <div>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-box"></i> Informasi Barang
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kode Barang</label>
                        <p class="form-control-plaintext">{{ $product->kode_barang }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Barang</label>
                        <p class="form-control-plaintext">{{ $product->nama_barang }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Stok Saat Ini</label>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-primary fs-5 me-2">
                                {{ $product->stok_saat_ini }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Satuan</label>
                        <p class="form-control-plaintext">{{ $product->satuan }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Dibuat Pada</label>
                        <p class="form-control-plaintext">{{ $product->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Terakhir Diupdate</label>
                        <p class="form-control-plaintext">{{ $product->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Transaksi -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock-history"></i> Riwayat Transaksi
                </h5>
            </div>
            <div class="card-body">
                @if($product->history()->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Tipe</th>
                                    <th>Jumlah</th>
                                    <th>User</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->history()->with('user')->orderBy('created_at', 'desc')->limit(10)->get() as $history)
                                <tr>
                                    <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($history->tipe_transaksi == 'masuk')
                                            <span class="badge bg-success">Masuk</span>
                                        @else
                                            <span class="badge bg-danger">Keluar</span>
                                        @endif
                                    </td>
                                    <td>{{ $history->jumlah }}</td>
                                    <td>{{ $history->user->name }}</td>
                                    <td>{{ $history->catatan ?: '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($product->history()->count() > 10)
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                Lihat Semua Transaksi ({{ $product->history()->count() }})
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-clock-history display-4 text-muted"></i>
                        <p class="text-muted mt-2">Belum ada transaksi untuk barang ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Statistik -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-graph-up"></i> Statistik
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            <h4 class="text-primary mb-1">{{ $product->history()->count() }}</h4>
                            <small class="text-muted">Total Transaksi</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            <h4 class="text-success mb-1">{{ $product->history()->masuk()->count() }}</h4>
                            <small class="text-muted">Transaksi Masuk</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            <h4 class="text-danger mb-1">{{ $product->history()->keluar()->count() }}</h4>
                            <small class="text-muted">Transaksi Keluar</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            <h4 class="text-info mb-1">{{ $product->history()->count() > 0 ? $product->history()->latest()->first()->created_at->diffForHumans() : '-' }}</h4>
                            <small class="text-muted">Transaksi Terakhir</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aksi Cepat -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning"></i> Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Tambah Stok
                    </a>
                    <a href="#" class="btn btn-danger">
                        <i class="bi bi-dash-circle"></i> Kurangi Stok
                    </a>
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit Barang
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection 