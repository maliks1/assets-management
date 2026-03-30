@extends('layouts.app')

@section('title', 'Laporan Nilai Aset - Sistem Gudang')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Laporan Nilai Aset</h1>
            <div>
                <button type="button" class="btn btn-success" onclick="exportData()">
                    <i class="bi bi-download"></i> Ekspor CSV
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
                <form method="GET" action="{{ route('reports.asset-value') }}" id="filterForm">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="category" class="form-label">Kategori Aset</label>
                            <select class="form-select" id="category" name="category">
                                <option value="semua" {{ request('category', 'semua') == 'semua' ? 'selected' : '' }}>Semua Kategori</option>
                                <option value="peralatan" {{ request('category') == 'peralatan' ? 'selected' : '' }}>Peralatan</option>
                                <option value="perlengkapan" {{ request('category') == 'perlengkapan' ? 'selected' : '' }}>Perlengkapan</option>
                                <option value="persediaan" {{ request('category') == 'persediaan' ? 'selected' : '' }}>Persediaan</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3 d-flex align-items-end">
                            <div class="d-grid gap-2 w-100">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> Filter
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 d-flex align-items-end">
                            <div class="d-grid gap-2 w-100">
                                <a href="{{ route('reports.asset-value') }}" class="btn btn-outline-secondary">
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

<!-- Data Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-table"></i> Data Aset dan Penyusutan
                </h5>
            </div>
            <div class="card-body">
                @if($assets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Harga Perolehan</th>
                                    <th class="text-center">Tahun Perolehan</th>
                                    <th class="text-center">Umur Manfaat (Thn)</th>
                                    <th>Penyusutan Akumulasi</th>
                                    <th>Nilai Buku</th>
                                    <th class="text-center">Persentase Penyusutan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assets as $asset)
                                <tr>
                                    <td>
                                        <strong>{{ $asset->kode_barang }}</strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $asset->nama_barang }}</strong>
                                            @if($asset->sub_category)
                                                <br>
                                                <small class="text-muted">{{ $asset->sub_category }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($asset->category_type) }}</span>
                                    </td>
                                    <td class="text-end">
                                        Rp {{ number_format($asset->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        @if($asset->acquisition_date)
                                            {{ $asset->acquisition_date->format('d/m/Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($asset->useful_life_years)
                                            {{ $asset->useful_life_years }} tahun
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        Rp {{ number_format($asset->accumulated_depreciation, 0, ',', '.') }}
                                    </td>
                                    <td class="text-end">
                                        @php
                                            $bookValue = $asset->harga - $asset->accumulated_depreciation;
                                            $bookValue = max(0, $bookValue);
                                        @endphp
                                        <strong class="text-success">
                                            Rp {{ number_format($bookValue, 0, ',', '.') }}
                                        </strong>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            if ($asset->harga > 0) {
                                                $percentage = ($asset->accumulated_depreciation / $asset->harga) * 100;
                                                $percentage = min(100, $percentage);
                                            } else {
                                                $percentage = 0;
                                            }
                                        @endphp
                                        <span class="badge {{ $percentage >= 75 ? 'bg-danger' : ($percentage >= 50 ? 'bg-warning' : 'bg-success') }}">
                                            {{ number_format($percentage, 1) }}%
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox display-4"></i>
                                                <h4 class="mt-3">Tidak ada data aset</h4>
                                                <p>Tidak ada aset yang sesuai dengan filter yang dipilih.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary Section -->
                    @php
                        $totalHarga = $assets->getCollection()->sum('harga');
                        $totalDepreciation = $assets->getCollection()->sum('accumulated_depreciation');
                        $totalBookValue = $totalHarga - $totalDepreciation;
                    @endphp
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <small class="text-muted d-block mb-2">Total Harga Perolehan</small>
                                    <h5 class="mb-0">Rp {{ number_format($totalHarga, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <small class="text-muted d-block mb-2">Total Penyusutan</small>
                                    <h5 class="mb-0">Rp {{ number_format($totalDepreciation, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <small class="text-muted d-block mb-2">Total Nilai Buku</small>
                                    <h5 class="mb-0 text-success">Rp {{ number_format($totalBookValue, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <small class="text-muted d-block mb-2">Jumlah Aset</small>
                                    <h5 class="mb-0">{{ $assets->getCollection()->count() }} item</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if($assets->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $assets->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <h4 class="mt-3 text-muted">Tidak ada aset</h4>
                        <p class="text-muted">Belum ada data aset yang tersedia dalam sistem.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function exportData() {
    const category = document.getElementById('category').value;
    const filename = 'laporan_nilai_aset_' + new Date().toISOString().slice(0,10) + '.csv';
    
    const headers = [
        'Kode Barang',
        'Nama Barang',
        'Kategori',
        'Harga Perolehan',
        'Tahun Perolehan',
        'Umur Manfaat (Tahun)',
        'Penyusutan Akumulasi',
        'Nilai Buku',
        'Persentase Penyusutan'
    ];
    
    const rows = [];
    const tables = document.querySelectorAll('table tbody tr');
    
    tables.forEach(row => {
        if (row.cells.length > 0) {
            const data = Array.from(row.cells).slice(0, 9).map(cell => {
                let text = cell.textContent.trim();
                // Remove any special formatting
                text = text.replace(/\n/g, ' ').replace(/\s+/g, ' ');
                // Handle currency values
                if (text.startsWith('Rp')) {
                    text = text.replace(/Rp\s+/, '').replace(/\./g, '');
                }
                return '"' + text + '"';
            });
            rows.push(data.join(','));
        }
    });
    
    const csv = headers.map(h => '"' + h + '"').join(',') + '\n' + rows.join('\n');
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', filename);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
@endsection
