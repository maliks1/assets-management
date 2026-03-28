@extends('layouts.app')

@section('title', 'Laporan Histori Transaksi - Sistem Gudang')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Laporan Histori Transaksi</h1>
            <div>
                <button type="button" class="btn btn-success" onclick="exportData()">
                    <i class="bi bi-download"></i> Ekspor CSV
                </button>
                <button type="button" class="btn btn-danger" onclick="exportPDF()">
                    <i class="bi bi-file-pdf"></i> Cetak PDF
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filter Form -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-funnel"></i> Filter Data
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('reports.transaction-history') }}" id="filterForm">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="start_date" class="form-label">Dari Tanggal</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="end_date" class="form-label">Sampai Tanggal</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="transaction_type" class="form-label">Tipe Transaksi</label>
                            <select class="form-select" id="transaction_type" name="transaction_type">
                                <option value="all" {{ request('transaction_type') == 'all' ? 'selected' : '' }}>Semua</option>
                                <option value="masuk" {{ request('transaction_type') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                                <option value="keluar" {{ request('transaction_type') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="product_id" class="form-label">Produk</label>
                            <select class="form-select" id="product_id" name="product_id">
                                <option value="all" {{ request('product_id') == 'all' ? 'selected' : '' }}>Semua Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->kode_barang }} - {{ $product->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <div class="d-grid gap-2 w-100">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> Filter
                                </button>
                                <a href="{{ route('reports.transaction-history') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Results Summary -->
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            Menampilkan {{ $transactions->total() }} transaksi
            @if(request('start_date') || request('end_date') || request('transaction_type') != 'all' || request('product_id') != 'all')
                dengan filter yang dipilih
            @endif
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-table"></i> Data Transaksi
                </h5>
            </div>
            <div class="card-body">
                @if($transactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Tipe</th>
                                    <th>Jumlah</th>
                                    <th>Dicatat Oleh</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $index => $transaction)
                                <tr>
                                    <td>{{ $transactions->firstItem() + $index }}</td>
                                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <strong>{{ $transaction->product->kode_barang ?? '-' }}</strong>
                                    </td>
                                    <td>{{ $transaction->product->nama_barang ?? '-' }}</td>
                                    <td>
                                        @if($transaction->tipe_transaksi == 'masuk')
                                            <span class="badge bg-success">
                                                <i class="bi bi-arrow-down"></i> Masuk
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bi bi-arrow-up"></i> Keluar
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ number_format($transaction->jumlah) }}</strong>
                                    </td>
                                    <td>{{ $transaction->user->name ?? '-' }}</td>
                                    <td>
                                        @if($transaction->catatan)
                                            <span class="text-muted">{{ $transaction->catatan }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Menampilkan {{ $transactions->firstItem() }} - {{ $transactions->lastItem() }} 
                            dari {{ $transactions->total() }} data
                        </div>
                        <div>
                            {{ $transactions->appends(request()->query())->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <h4 class="mt-3 text-muted">Tidak ada data transaksi</h4>
                        <p class="text-muted">Coba ubah filter atau tanggal pencarian Anda.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Export Forms (Hidden) -->
<form id="exportForm" method="GET" action="{{ route('reports.export-transaction-history') }}" style="display: none;">
    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
    <input type="hidden" name="transaction_type" value="{{ request('transaction_type') }}">
    <input type="hidden" name="product_id" value="{{ request('product_id') }}">
</form>

<form id="exportPDFForm" method="GET" action="{{ route('reports.export-transaction-history-pdf') }}" style="display: none;">
    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
    <input type="hidden" name="transaction_type" value="{{ request('transaction_type') }}">
    <input type="hidden" name="product_id" value="{{ request('product_id') }}">
</form>

<script>
function exportData() {
    // Copy current filter values to export form
    document.getElementById('exportForm').querySelector('input[name="start_date"]').value = 
        document.getElementById('start_date').value;
    document.getElementById('exportForm').querySelector('input[name="end_date"]').value = 
        document.getElementById('end_date').value;
    document.getElementById('exportForm').querySelector('input[name="transaction_type"]').value = 
        document.getElementById('transaction_type').value;
    document.getElementById('exportForm').querySelector('input[name="product_id"]').value = 
        document.getElementById('product_id').value;
    
    // Submit export form
    document.getElementById('exportForm').submit();
}

function exportPDF() {
    // Copy current filter values to export PDF form
    document.getElementById('exportPDFForm').querySelector('input[name="start_date"]').value = 
        document.getElementById('start_date').value;
    document.getElementById('exportPDFForm').querySelector('input[name="end_date"]').value = 
        document.getElementById('end_date').value;
    document.getElementById('exportPDFForm').querySelector('input[name="transaction_type"]').value = 
        document.getElementById('transaction_type').value;
    document.getElementById('exportPDFForm').querySelector('input[name="product_id"]').value = 
        document.getElementById('product_id').value;
    
    // Submit export PDF form
    document.getElementById('exportPDFForm').submit();
}
</script>
@endsection