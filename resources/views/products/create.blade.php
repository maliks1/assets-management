@extends('layouts.app')

@section('title', 'Tambah Produk - Sistem Gudang')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Tambah Produk Baru</h1>
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
                    <i class="bi bi-plus-circle"></i> Form Tambah Produk
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

                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kode_barang" class="form-label">
                                Kode Barang <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('kode_barang') is-invalid @enderror" 
                                   id="kode_barang" 
                                   name="kode_barang" 
                                   value="{{ old('kode_barang') }}" 
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
                                   value="{{ old('nama_barang') }}" 
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
                                  placeholder="Deskripsi produk (opsional)">{{ old('deskripsi') }}</textarea>
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
                                   value="{{ old('stok_saat_ini', 0) }}" 
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
                                   value="{{ old('stok_minimum', 5) }}" 
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
                                <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : '' }}>Kg</option>
                                <option value="liter" {{ old('satuan') == 'liter' ? 'selected' : '' }}>Liter</option>
                                <option value="meter" {{ old('satuan') == 'meter' ? 'selected' : '' }}>Meter</option>
                                <option value="box" {{ old('satuan') == 'box' ? 'selected' : '' }}>Box</option>
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
                                   value="{{ old('harga', 0) }}" 
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
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Simpan Produk
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
                    <i class="bi bi-info-circle"></i> Informasi
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6 class="alert-heading">Panduan Pengisian:</h6>
                    <ul class="mb-0">
                        <li><strong>Kode Barang:</strong> Harus unik dan tidak boleh kosong</li>
                        <li><strong>Nama Barang:</strong> Nama lengkap produk</li>
                        <li><strong>Deskripsi:</strong> Penjelasan detail produk (opsional)</li>
                        <li><strong>Stok Saat Ini:</strong> Jumlah stok yang tersedia</li>
                        <li><strong>Stok Minimum:</strong> Batas minimum sebelum peringatan</li>
                    </ul>
                </div>
                
                <div class="alert alert-warning">
                    <h6 class="alert-heading">Perhatian:</h6>
                    <p class="mb-0">Setelah produk dibuat, Anda dapat menambahkan transaksi masuk untuk menambah stok awal.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
