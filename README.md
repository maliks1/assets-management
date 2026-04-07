# Assets Management System

Aplikasi manajemen aset berbasis Laravel untuk mengelola data barang, transaksi stok, nilai aset, dan pencatatan depresiasi bulanan.

## Ringkasan Fitur

- Autentikasi pengguna (login, register, logout).
- Dashboard ringkasan operasional:
  - total barang,
  - total stok,
  - total nilai stok,
  - ringkasan per kategori,
  - transaksi hari ini (masuk/keluar),
  - 5 transaksi terbaru.
- Manajemen master barang (CRUD) dengan kategori:
  - persediaan,
  - perlengkapan,
  - peralatan.
- Manajemen stok melalui transaksi:
  - barang masuk,
  - barang keluar (dengan validasi stok tidak boleh minus).
- Riwayat transaksi lengkap dengan pencatat (user) dan catatan transaksi.
- Laporan histori transaksi:
  - filter tanggal,
  - filter tipe transaksi,
  - filter barang,
  - ekspor CSV,
  - ekspor PDF.
- Laporan nilai aset/depresiasi dengan filter kategori dan pencarian.
- Pencatatan depresiasi bulanan metode garis lurus (straight-line) dengan tabel histori depresiasi per periode.

## Fitur Depresiasi

Fitur depresiasi memakai metode garis lurus dengan parameter utama:

- nilai perolehan,
- nilai residu,
- umur manfaat,
- tanggal perolehan.

Implementasi saat ini mencatat depresiasi bulanan menggunakan command artisan berikut:

```bash
php artisan depreciation:record
```

Opsi periode (format YYYY-MM):

```bash
php artisan depreciation:record --period=2026-04
```

Hasil pencatatan disimpan ke tabel depreciation_records dan nilai akumulasi depresiasi pada produk ikut diperbarui.

## Stack Teknologi

- Backend: Laravel 12
- PHP: 8.2+
- Database: MySQL/MariaDB
- Frontend: Blade + Bootstrap 5 (Vite)
- Export PDF: barryvdh/laravel-dompdf

## Instalasi

### Prasyarat

- PHP 8.2+
- Composer
- MySQL/MariaDB
- Node.js dan npm

### Langkah Setup

1. Clone repository, lalu masuk ke folder proyek.
2. Install dependency backend dan frontend.

```bash
composer install
npm install
```

3. Siapkan environment.

```bash
cp .env.example .env
php artisan key:generate
```

4. Atur koneksi database di file .env.
5. Jalankan migrasi dan seeder.

```bash
php artisan migrate --seed
```

6. Jalankan aset frontend (opsional untuk development).

```bash
npm run dev
```

7. Jalankan aplikasi.

```bash
php artisan serve
```

Default URL: http://localhost:8000

## Data Seed Awal

Seeder menyiapkan:

- 5 akun pengguna contoh (domain ike.co.id), termasuk admin.
- Data barang lintas kategori persediaan, perlengkapan, dan peralatan.
- Data histori transaksi.
- Data depresiasi contoh per periode.

Password default akun seed: password

## Struktur Data Inti

### users

- Menyimpan akun pengguna aplikasi.

### products

- Menyimpan master barang/aset.
- Field utama mencakup identitas barang, stok, harga, kategori, sub-kategori, nomor proyek, serta parameter depresiasi.

### history

- Menyimpan histori transaksi stok masuk/keluar.
- Terhubung ke produk dan user.

### depreciation_records

- Menyimpan histori depresiasi bulanan per barang.
- Memiliki unique key product_id + period untuk mencegah duplikasi periode yang sama.

## Route Utama

- /login, /register, /logout
- /dashboard
- /products (resource CRUD)
- /transactions/barang-masuk
- /transactions/barang-keluar
- /reports/transaction-history
- /reports/export-transaction-history
- /reports/export-transaction-history-pdf
- /reports/nilai-aset

## Pengujian

Jalankan test dengan:

```bash
php artisan test
```

## Catatan Implementasi

- Otorisasi policy produk sudah terhubung, namun saat ini aturan policy masih mengizinkan semua user terautentikasi.
- Penghapusan barang diblokir jika barang sudah memiliki histori transaksi.

## Lisensi

Proyek ini menggunakan lisensi Apache. Lihat file LICENSE untuk detail.
