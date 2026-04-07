@extends('layouts.app')

@section('title', 'Transaksi Barang Keluar - Sistem Gudang')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Barang Keluar</h1>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-danger text-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-dash-circle me-2"></i>Form Transaksi Barang Keluar
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-light border mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Pilih barang kategori <strong>persediaan</strong> atau <strong>perlengkapan</strong>, lalu masukkan jumlah yang akan dikeluarkan.
                    </div>

                    @if($products->isEmpty())
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Belum ada barang kategori persediaan/perlengkapan yang tersedia untuk transaksi keluar.
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6 class="alert-heading">Terjadi kesalahan:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('transactions.barang-keluar.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="product_id" class="form-label fw-semibold">Pilih Barang <span class="text-danger">*</span></label>
                            <select class="form-select @error('product_id') is-invalid @enderror" id="product_id" name="product_id" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->kode_barang }} - {{ $product->nama_barang }} (Stok: {{ $product->stok_saat_ini }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="jumlah" class="form-label fw-semibold">Jumlah Barang Keluar <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" min="1" value="{{ old('jumlah', 1) }}" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-danger" {{ $products->isEmpty() ? 'disabled' : '' }}>
                                <i class="bi bi-check-circle me-1"></i>Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection 