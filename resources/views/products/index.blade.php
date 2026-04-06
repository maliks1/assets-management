@extends('layouts.app')

@section('title', 'Data Aset - Sistem Gudang')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Data Aset</h1>
            </div>
        </div>
    </div>

    <!-- Category Filter Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                <div class="btn-group" role="group" aria-label="Filter kategori aset">
                    <a href="{{ route('products.index', ['category' => 'semua', 'search' => request('search')]) }}"
                        class="btn btn-outline-primary {{ $category === 'semua' ? 'active' : '' }}">
                        <i class="bi bi-collection"></i> Semua
                    </a>
                    <a href="{{ route('products.index', ['category' => 'peralatan', 'search' => request('search')]) }}"
                        class="btn btn-outline-primary {{ $category === 'peralatan' ? 'active' : '' }}">
                        <i class="bi bi-tools"></i> Peralatan
                    </a>
                    <a href="{{ route('products.index', ['category' => 'perlengkapan', 'search' => request('search')]) }}"
                        class="btn btn-outline-primary {{ $category === 'perlengkapan' ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i> Perlengkapan
                    </a>
                    <a href="{{ route('products.index', ['category' => 'persediaan', 'search' => request('search')]) }}"
                        class="btn btn-outline-primary {{ $category === 'persediaan' ? 'active' : '' }}">
                        <i class="bi bi-archive"></i> Persediaan
                    </a>
                </div>

                <form action="{{ route('products.index') }}" method="GET" class="d-flex align-items-center ms-auto"
                    style="max-width: 460px; width: 100%;">
                    <input type="hidden" name="category" value="{{ $category }}">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="search"
                            placeholder="Cari berdasarkan nama atau kode barang..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Stok Saat Ini</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>
                                                <strong>{{ $product->kode_barang }}</strong>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $product->nama_barang }}</strong>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary fs-6">
                                                    {{ $product->stok_saat_ini }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info"
                                                        title="Lihat Detail">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning"
                                                        title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $product->id }}">Konfirmasi
                                                            Hapus</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus barang
                                                            <strong>{{ $product->nama_barang }}</strong>?</p>
                                                        <p class="text-danger mb-0">
                                                            <i class="bi bi-exclamation-triangle"></i>
                                                            Tindakan ini tidak dapat dibatalkan!
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('products.destroy', $product) }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($products->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $products->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-box display-1 text-muted"></i>
                            <h4 class="mt-3 text-muted">Belum ada barang</h4>
                            <p class="text-muted">Mulai dengan menambahkan barang pertama Anda.</p>
                            <a href="{{ route('products.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Tambah Barang Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection