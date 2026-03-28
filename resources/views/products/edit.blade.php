@extends('layouts.app')

@section('title', 'Edit Produk - Sistem Gudang')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            {{-- <h1 class="h3 mb-0">Edit Produk</h1>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a> --}}
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
                        <div class="col-md-3 mb-3">
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
                        </div>

                        <div class="col-md-4 mb-3">
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

                        <div class="col-md-3 mb-3">
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
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
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
                            {{-- <div class="form-text">Batas minimum sebelum peringatan</div> --}}
                        </div>

                        <div class="col-md-3 mb-3">
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

                        <div class="col-md-3 mb-3">
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

                    <!-- Category Section -->
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
                                <option value="persediaan" {{ old('category_type', $product->category_type) == 'persediaan' ? 'selected' : '' }}>Persediaan (Inventory)</option>
                                <option value="perlengkapan" {{ old('category_type', $product->category_type) == 'perlengkapan' ? 'selected' : '' }}>Perlengkapan (Supplies)</option>
                                <option value="peralatan" {{ old('category_type', $product->category_type) == 'peralatan' ? 'selected' : '' }}>Peralatan (Equipment)</option>
                            </select>
                            @error('category_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Pilih tipe produk</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="sub_category" class="form-label">Sub Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('sub_category') is-invalid @enderror"
                                    id="sub_category"
                                    name="sub_category"
                                    required>
                                <option value="project" {{ old('sub_category', $product->sub_category) == 'project' ? 'selected' : '' }}>Project</option>
                                <option value="kantor" {{ old('sub_category', $product->sub_category) == 'kantor' ? 'selected' : '' }}>Kantor</option>
                            </select>
                            @error('sub_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Pilih kategori sub untuk produk ini</div>
                        </div>
                    </div>

                    <div class="mb-3" id="no_project_container" style="display: none;">
                        <label for="no_project" class="form-label">No Project</label>
                        <input type="text"
                               class="form-control @error('no_project') is-invalid @enderror"
                               id="no_project"
                               name="no_project"
                               value="{{ old('no_project', $product->no_project) }}"
                               placeholder="Project number related">
                        @error('no_project')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Depreciation Section (for Equipment only) -->
                    <div id="depreciation-section" class="mt-4" style="display: none;">
                        <hr class="my-4">
                        <h5 class="mb-3"><i class="bi bi-calculator"></i> Depresiasi</h5>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> <strong>Info:</strong> Depresiasi hanya berlaku untuk produk dengan tipe "Perlengkapan/Equipment". Gunakan metode garis lurus.
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="acquisition_date" class="form-label">Tanggal Perolehan</label>
                                <input type="date"
                                       class="form-control @error('acquisition_date') is-invalid @enderror"
                                       id="acquisition_date"
                                       name="acquisition_date"
                                       value="{{ old('acquisition_date', $product->acquisition_date?->format('Y-m-d')) }}">
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
                                       value="{{ old('useful_life_years', $product->useful_life_years) }}"
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
                                       value="{{ old('salvage_value', $product->salvage_value ?? 0) }}"
                                       min="0"
                                       step="0.01">
                                @error('salvage_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Nilai residu di akhir masa manfaat</div>
                            </div>
                        </div>

                        @if($product->accumulated_depreciation > 0)
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-secondary">
                                    <h6 class="alert-heading"><i class="bi bi-graph-up"></i> Status Depresiasi Saat Ini</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small><strong>Depresiasi Terakumulasi:</strong></small><br>
                                            <span class="text-primary">Rp {{ number_format($product->accumulated_depreciation, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="col-md-4">
                                            <small><strong>Nilai Buku:</strong></small><br>
                                            <span class="text-success">Rp {{ number_format($product->book_value, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="col-md-4">
                                            <small><strong>Status:</strong></small><br>
                                            @if($product->isFullyDepreciated())
                                                <span class="badge bg-danger">Fully Depreciated</span>
                                            @else
                                                <span class="badge bg-info">In Progress</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
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
                    <strong>Tipe Kategori:</strong><br>
                    @if($product->category_type === 'perlengkapan')
                        <span class="badge bg-info">Perlengkapan/Equipment</span>
                    @else
                        <span class="badge bg-primary">Persediaan/Inventory</span>
                    @endif
                </div>

                @if($product->category_type === 'perlengkapan' && $product->acquisition_date)
                <div class="mb-3">
                    <strong>Info Depresiasi:</strong><br>
                    <small class="text-muted">
                        Tanggal Perolehan: {{ $product->acquisition_date->format('d/m/Y') }}<br>
                        Masa Manfaat: {{ $product->useful_life_years }} tahun<br>
                        Nilai Sisa: Rp {{ number_format($product->salvage_value ?? 0, 0, ',', '.') }}
                    </small>
                </div>
                @endif

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

        {{-- <div class="card mt-3">
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
        </div> --}}
    </div>
</div>

<script>
// Show/hide depreciation section based on category type
// Show/hide no_project field based on sub_category
document.addEventListener('DOMContentLoaded', function() {
    const categoryTypeSelect = document.getElementById('category_type');
    const depreciationSection = document.getElementById('depreciation-section');
    const subCategorySelect = document.getElementById('sub_category');
    const noProjectContainer = document.getElementById('no_project_container');
    const noProjectInput = document.getElementById('no_project');

    function toggleDepreciationSection() {
        if (categoryTypeSelect.value === 'perlengkapan') {
            depreciationSection.style.display = 'block';
        } else {
            depreciationSection.style.display = 'none';
            // Optional: Clear depreciation fields when hidden (commented out to preserve data)
            // document.getElementById('acquisition_date').value = '';
            // document.getElementById('useful_life_years').value = '';
            // document.getElementById('salvage_value').value = '0';
        }
    }

    function toggleNoProjectField() {
        if (subCategorySelect.value === 'project') {
            noProjectContainer.style.display = 'block';
            noProjectInput.setAttribute('required', 'required');
        } else {
            noProjectContainer.style.display = 'none';
            noProjectInput.removeAttribute('required');
            noProjectInput.value = ''; // Clear the value when hidden
        }
    }

    categoryTypeSelect.addEventListener('change', toggleDepreciationSection);
    subCategorySelect.addEventListener('change', toggleNoProjectField);

    // Initial checks
    toggleDepreciationSection();
    toggleNoProjectField();
});
</script>
@endsection
