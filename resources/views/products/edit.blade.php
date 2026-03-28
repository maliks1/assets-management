@extends('layouts.app')

@section('title', 'Edit Produk - Sistem Gudang')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Edit Produk</h1>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-pencil"></i> Form Edit Produk
                </h5>
            </div>
            <div class="card-body">
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

                <form action="{{ route('products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kode_barang" class="form-label">
                                Kode Barang <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('kode_barang') is-invalid @enderror" 
                                   id="kode_barang" 
                                   name="kode_barang" 
                                   value="{{ old('kode_barang', $product->kode_barang) }}" 
                                   placeholder="Contoh: PRD001"
                                   required>
                            @error('kode_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Kode unik untuk mengidentifikasi produk</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nama_barang" class="form-label">
                                Nama Barang <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_barang') is-invalid @enderror" 
                                   id="nama_barang" 
                                   name="nama_barang" 
                                   value="{{ old('nama_barang', $product->nama_barang) }}" 
                                   placeholder="Contoh: Laptop Asus ROG"
                                   required>
                            @error('nama_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" 
                                  name="deskripsi" 
                                  rows="3" 
                                  placeholder="Deskripsi produk (opsional)">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="stok_saat_ini" class="form-label">
                                Stok Saat Ini <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('stok_saat_ini') is-invalid @enderror" 
                                   id="stok_saat_ini" 
                                   name="stok_saat_ini" 
                                   value="{{ old('stok_saat_ini', $product->stok_saat_ini) }}" 
                                   min="0"
                                   required>
                            @error('stok_saat_ini')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="stok_minimum" class="form-label">
                                Stok Minimum <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('stok_minimum') is-invalid @enderror" 
                                   id="stok_minimum" 
                                   name="stok_minimum" 
                                   value="{{ old('stok_minimum', $product->stok_minimum) }}" 
                                   min="0"
                                   required>
                            @error('stok_minimum')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Batas minimum sebelum peringatan</div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="satuan" class="form-label">
                                Satuan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('satuan') is-invalid @enderror" 
                                    id="satuan" 
                                    name="satuan" 
                                    required>
                                <option value="pcs" {{ old('satuan', $product->satuan) == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                <option value="kg" {{ old('satuan', $product->satuan) == 'kg' ? 'selected' : '' }}>Kg</option>
                                <option value="liter" {{ old('satuan', $product->satuan) == 'liter' ? 'selected' : '' }}>Liter</option>
                                <option value="meter" {{ old('satuan', $product->satuan) == 'meter' ? 'selected' : '' }}>Meter</option>
                                <option value="box" {{ old('satuan', $product->satuan) == 'box' ? 'selected' : '' }}>Box</option>
                            </select>
                            @error('satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="harga" class="form-label">
                                Harga Satuan
                            </label>
                            <input type="number" 
                                   class="form-control @error('harga') is-invalid @enderror" 
                                   id="harga" 
                                   name="harga" 
                                   value="{{ old('harga', $product->harga) }}" 
                                   min="0"
                                   step="0.01">
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Harga per satuan (opsional)</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle"></i> Update Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i> Informasi Produk
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Status Stok:</strong>
                    @if($product->stok_saat_ini > $product->stok_minimum)
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle"></i> Aman
                        </span>
                    @else
                        <span class="badge bg-warning">
                            <i class="bi bi-exclamation-triangle"></i> Menipis
                        </span>
                    @endif
                </div>

                <div class="mb-3">
                    <strong>Dibuat:</strong><br>
                    <small class="text-muted">{{ $product->created_at->format('d/m/Y H:i') }}</small>
                </div>

                <div class="mb-3">
                    <strong>Terakhir Diupdate:</strong><br>
                    <small class="text-muted">{{ $product->updated_at->format('d/m/Y H:i') }}</small>
                </div>

                @if($product->history()->count() > 0)
                    <div class="alert alert-info">
                        <h6 class="alert-heading">Riwayat Transaksi:</h6>
                        <p class="mb-0">Produk ini memiliki {{ $product->history()->count() }} transaksi.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-exclamation-triangle"></i> Perhatian
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <h6 class="alert-heading">Peringatan:</h6>
                    <ul class="mb-0">
                        <li>Perubahan kode barang akan mempengaruhi semua transaksi terkait</li>
                        <li>Stok saat ini sebaiknya diubah melalui transaksi masuk/keluar</li>
                        <li>Produk dengan riwayat transaksi tidak dapat dihapus</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
