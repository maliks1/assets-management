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

                    <input type="hidden" name="accumulated_depreciation" value="0">

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

                    <div class="row">
                        <div class="col-md-6 mb-3">
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

                        <div class="col-md-6 mb-3">
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

                    <!-- Category Section -->
                    <hr class="my-4">
                    <h5 class="mb-3"><i class="bi bi-folder"></i> Kategori Produk</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category_type" class="form-label">
                                Tipe Kategori <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('category_type') is-invalid @enderror"
                                    id="category_type"
                                    name="category_type"
                                    required>
                                <option value="persediaan" {{ old('category_type') == 'persediaan' ? 'selected' : '' }}>Persediaan (Inventory)</option>
                                <option value="perlengkapan" {{ old('category_type') == 'perlengkapan' ? 'selected' : '' }}>Perlengkapan (Equipment)</option>
                                <option value="peralatan" {{ old('category_type') == 'peralatan' ? 'selected' : '' }}>Peralatan (Equipment)</option>
                            </select>
                            @error('category_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Pilih tipe produk</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="sub_category" class="form-label">Sub Kategori</label>
                            <input type="text"
                                   class="form-control @error('sub_category') is-invalid @enderror"
                                   id="sub_category"
                                   name="sub_category"
                                   value="{{ old('sub_category') }}"
                                   placeholder="Contoh: Elektronik, Furniture">
                            @error('sub_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="no_project" class="form-label">Nomor Project</label>
                        <input type="text"
                               class="form-control @error('no_project') is-invalid @enderror"
                               id="no_project"
                               name="no_project"
                               value="{{ old('no_project') }}"
                               placeholder="Nomor project terkait (opsional)">
                        @error('no_project')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Depreciation Section (for Equipment only) -->
                    <div id="depreciation-section" class="mt-4" style="display: none;">
                        <hr class="my-4">
                        <h5 class="mb-3"><i class="bi bi-calculator"></i> Depresiasi (Khusus Peralatan/Equipment)</h5>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> <strong>Info:</strong> Depresiasi hanya berlaku untuk produk dengan tipe "Peralatan/Equipment". Gunakan metode garis lurus.
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="acquisition_date" class="form-label">Tanggal Perolehan</label>
                                <input type="date"
                                       class="form-control @error('acquisition_date') is-invalid @enderror"
                                       id="acquisition_date"
                                       name="acquisition_date"
                                       value="{{ old('acquisition_date') }}">
                                @error('acquisition_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Tanggal barang/equipment diperoleh</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="useful_life_years" class="form-label">Masa Manfaat (Tahun)</label>
                                <input type="number"
                                       class="form-control @error('useful_life_years') is-invalid @enderror"
                                       id="useful_life_years"
                                       name="useful_life_years"
                                       value="{{ old('useful_life_years') }}"
                                       min="1"
                                       max="50">
                                @error('useful_life_years')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Estimasi masa manfaat dalam tahun</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="salvage_value" class="form-label">Nilai Sisa (Salvage Value)</label>
                                <input type="number"
                                       class="form-control @error('salvage_value') is-invalid @enderror"
                                       id="salvage_value"
                                       name="salvage_value"
                                       value="{{ old('salvage_value', 0) }}"
                                       min="0"
                                       step="0.01">
                                @error('salvage_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Nilai residu di akhir masa manfaat</div>
                            </div>
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
                        <li><strong>Stok Saat Ini:</strong> Jumlah stok yang tersedia</li>
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

<script>
// Show/hide depreciation section based on category type
document.addEventListener('DOMContentLoaded', function() {
    const categoryTypeSelect = document.getElementById('category_type');
    const depreciationSection = document.getElementById('depreciation-section');

    function toggleDepreciationSection() {
        if (categoryTypeSelect.value === 'peralatan') {
            depreciationSection.style.display = 'block';
        } else {
            depreciationSection.style.display = 'none';
            // Clear depreciation fields when hidden
            document.getElementById('acquisition_date').value = '';
            document.getElementById('useful_life_years').value = '';
            document.getElementById('salvage_value').value = '0';
        }
    }

    categoryTypeSelect.addEventListener('change', toggleDepreciationSection);

    // Initial check
    toggleDepreciationSection();
});
</script>
@endsection
