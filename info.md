# Ringkasan Fitur Project Assets Management

## 1. Gambaran Umum
Project ini adalah aplikasi Laravel untuk manajemen aset/barang perusahaan, mencakup:
- manajemen master data aset,
- transaksi barang masuk dan barang keluar,
- histori transaksi dan pelaporan,
- nilai aset dan depresiasi,
- autentikasi user,
- API produk.

Domain kategori barang yang dipakai:
- persediaan,
- perlengkapan,
- peralatan.

## 2. Fitur Autentikasi dan Akses
Fitur autentikasi web:
- Login (email + password).
- Register akun baru.
- Logout dengan invalidasi session dan regenerate CSRF token.

Pengamanan route:
- Route guest: login dan register.
- Route auth: dashboard, produk, transaksi, laporan.

Catatan otorisasi:
- ProductPolicy sudah terpasang via Gate policy.
- Saat ini semua method policy mengembalikan true, artinya semua user yang sudah login dapat melakukan seluruh aksi terkait produk/stok.

## 3. Dashboard Operasional
Dashboard menampilkan ringkasan operasional utama:
- Total jenis barang (count products).
- Total stok barang (sum stok_saat_ini).
- Total nilai stok (sum stok_saat_ini * harga).
- Ringkasan kategori (per kategori: total item dan total stok).
- Ringkasan transaksi hari ini:
  - jumlah transaksi masuk/keluar,
  - total kuantitas masuk/keluar.
- Aktivitas terbaru: 5 transaksi terakhir.

Aksi cepat dari dashboard:
- tombol menuju Barang Masuk,
- tombol menuju Barang Keluar.

## 4. Manajemen Data Aset (Produk)
### 4.1 CRUD Produk (Web)
Fitur utama:
- List data aset dengan pagination.
- Filter kategori via tab (semua, peralatan, perlengkapan, persediaan).
- Search berdasarkan nama barang atau kode barang.
- Detail produk.
- Edit produk.
- Hapus produk.

Batasan hapus:
- Produk tidak bisa dihapus jika sudah punya riwayat transaksi (dicek di ProductService).

### 4.2 Form Input dan Aturan Dinamis
Pada form create/edit produk:
- Input data dasar: kode, nama, stok, satuan, harga.
- Input klasifikasi: category_type, sub_category, no_project.
- no_project wajib jika sub_category = project.
- Opsi sub_category dinamis berdasarkan category_type:
  - persediaan: hanya project,
  - perlengkapan/peralatan: kantor atau project.

### 4.3 Field Depresiasi pada Produk
Field depresiasi tersedia di model/tabel produk:
- acquisition_date,
- useful_life_years,
- salvage_value,
- accumulated_depreciation.

Perilaku UI:
- Bagian depresiasi ditampilkan ketika category_type = peralatan.
- Nilai buku diturunkan dari harga - accumulated_depreciation.

## 5. Manajemen Transaksi Stok
### 5.1 Barang Masuk
Fitur:
- Pilih produk,
- isi jumlah masuk,
- simpan transaksi tipe masuk,
- stok produk otomatis bertambah,
- histori transaksi dicatat dengan user login.

Validasi:
- product_id wajib dan harus ada.
- jumlah wajib integer minimal 1.

### 5.2 Barang Keluar
Fitur:
- Hanya produk kategori persediaan/perlengkapan yang boleh dipilih.
- Simpan transaksi tipe keluar.
- Stok otomatis berkurang.
- Histori transaksi dicatat dengan user login.

Validasi:
- product_id wajib dan dibatasi ke kategori persediaan/perlengkapan.
- jumlah wajib integer minimal 1.
- jumlah keluar tidak boleh melebihi stok saat ini (stok tidak boleh minus).

## 6. Histori Transaksi dan Pelaporan
### 6.1 Laporan Histori Transaksi (Web)
Fitur:
- Tabel histori transaksi dengan relasi produk + user.
- Filter:
  - rentang tanggal,
  - tipe transaksi (masuk/keluar),
  - produk.
- Pagination data hasil filter.
- Tampilan nominal total per baris (jumlah x harga produk).

### 6.2 Export Histori
Fitur export:
- Export CSV dari backend endpoint laporan.
- Export PDF menggunakan barryvdh/laravel-dompdf.
- Export mempertahankan filter aktif.

## 7. Laporan Nilai Aset
Fitur:
- Halaman laporan nilai aset dengan filter kategori dan search.
- Pagination.
- Ringkasan total pada halaman:
  - total harga perolehan,
  - total penyusutan,
  - total nilai buku,
  - jumlah aset.

Perilaku kolom berdasarkan kategori:
- Untuk persediaan/perlengkapan: kolom depresiasi disembunyikan, fokus ke harga perolehan.
- Untuk kategori lain (terutama peralatan): tampilkan kolom depresiasi lengkap:
  - harga perolehan,
  - tanggal perolehan,
  - umur manfaat,
  - penyusutan akumulasi,
  - nilai buku,
  - persentase penyusutan.

Export pada halaman ini:
- Export CSV dilakukan client-side (JavaScript) dari data tabel yang sedang tampil.

## 8. Fitur Depresiasi Aset
### 8.1 Formula
Metode yang dipakai: garis lurus (straight-line)
- Depresiasi tahunan = (harga - salvage_value) / useful_life_years
- Depresiasi bulanan = depresiasi tahunan / 12

### 8.2 Aturan Kelayakan Depresiasi (Service)
Aset bisa didepresiasi jika:
- category_type = peralatan,
- acquisition_date terisi,
- useful_life_years terisi dan > 0,
- aset belum fully depreciated.

### 8.3 Pencatatan Depresiasi Bulanan
Fitur di DepreciationService:
- Record per aset per periode bulanan (period diset ke tanggal 1 bulan berjalan/target).
- Cek duplikasi per product + period.
- Simpan detail ke depreciation_records:
  - depreciation_amount,
  - accumulated_depreciation,
  - book_value.
- Update accumulated_depreciation pada tabel products.
- Menjaga nilai buku tidak turun di bawah salvage_value.
- Berjalan dalam DB transaction.

### 8.4 Pencatatan Massal via Artisan Command
Command:
- php artisan depreciation:record
- php artisan depreciation:record --period=YYYY-MM

Output command:
- jumlah aset yang diproses,
- ringkasan total aset, nilai awal, akumulasi depresiasi, nilai buku, dan jumlah aset fully depreciated.

### 8.5 Depreciation Schedule dan Summary
Service juga menyediakan:
- getDepreciationSchedule(product): jadwal bulanan lengkap termasuk status sudah tercatat/belum.
- getTotalDepreciationForPeriod(period).
- getDepreciationSummary().

## 9. API Produk (REST)
Tersedia API dengan prefix:
- /api/v1/products

Endpoint resource:
- GET /api/v1/products
- POST /api/v1/products
- GET /api/v1/products/{id}
- PUT/PATCH /api/v1/products/{id}
- DELETE /api/v1/products/{id}

Karakteristik:
- Gunakan ProductService untuk logika data.
- Gunakan ProductResource untuk format response.
- API test endpoint: GET /api/test.

## 10. Validasi dan Rule Bisnis
### 10.1 ProductRequest
Rule penting:
- kode_barang unik.
- category_type wajib dan hanya 3 nilai valid.
- sub_category wajib dan dibatasi berdasarkan category_type.
- no_project wajib jika sub_category = project.
- stok minimal 0.
- harga/salvage/accumulated minimal 0.
- useful_life_years minimal 1 maksimal 50.

### 10.2 Relasi Data
- Product hasMany History.
- Product hasMany DepreciationRecord.
- History belongsTo Product dan User.
- DepreciationRecord belongsTo Product.

### 10.3 Scope Model
- History: scopeMasuk, scopeKeluar.
- DepreciationRecord: scopeForPeriod, scopeLatestPeriod.

## 11. Struktur Data Inti
Tabel utama:
- products:
  - data master barang + atribut kategori + atribut depresiasi.
- history:
  - log transaksi stok masuk/keluar per barang dan user.
- depreciation_records:
  - histori depresiasi per periode per barang.
  - unique constraint (product_id, period).
- users:
  - akun pengguna aplikasi.

## 12. Data Seed Bawaan
Seeder yang dijalankan:
- UsersTableSeeder.
- ProductsTableSeeder.
- HistoryTableSeeder.
- DepreciationRecordsTableSeeder.

Isi seed secara umum:
- 5 user contoh domain ike.co.id.
- master produk lintas kategori persediaan/perlengkapan/peralatan.
- histori transaksi contoh masuk/keluar.
- data depresiasi periode bulanan contoh.

## 13. Pengujian
Unit test tersedia untuk model Product:
- addStock memanggil increment dengan argumen benar.
- reduceStock mengurangi stok saat stok cukup.
- reduceStock gagal saat stok tidak cukup.

## 14. Catatan Implementasi Penting
- Policy sudah aktif tetapi belum membatasi per role (semua true).
- Terdapat ketidakkonsistenan implementasi depresiasi:
  - DepreciationService memproses kategori peralatan.
  - DepreciationRecordsTableSeeder men-generate data untuk kategori perlengkapan.
- Di UI, menu utama menampilkan Data Aset, Riwayat Transaksi, Nilai Aset.
  Fitur barang masuk/keluar diakses dari dashboard dan route transaksi.
- Export PDF histori tersedia di backend, tetapi tombol PDF di halaman histori saat ini dikomentari.
