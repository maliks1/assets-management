# Assets Management System

![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue)
![License](https://img.shields.io/badge/License-MIT-green)

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

- nilai perolehan (harga),
- nilai residu (salvage_value),
- umur manfaat (useful_life_years),
- tanggal perolehan (acquisition_date).

Implementasi saat ini mencatat depresiasi bulanan menggunakan command artisan berikut:

```bash
php artisan depreciation:record
```

Opsi periode (format YYYY-MM):

```bash
php artisan depreciation:record --period=2026-04
```

Hasil pencatatan disimpan ke tabel `depreciation_records` dan nilai akumulasi depresiasi pada produk ikut diperbarui.

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

4. Atur koneksi database di file `.env`.
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

## Konfigurasi Environment

File `.env` mendukung variabel berikut:

```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=assets_management
DB_USERNAME=root
DB_PASSWORD=

# App
APP_NAME="Assets Management System"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

# Mail (opsional)
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# Logging
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug
```

## Struktur Data Inti

### users

- Menyimpan akun pengguna aplikasi.
- Field: id, name, email, password, remember_token, created_at, updated_at

### products

- Menyimpan master barang/aset.
- Field:
  - id (primary key)
  - kode_barang (string, unique)
  - nama_barang (string)
  - stok_saat_ini (integer, default 0)
  - satuan (string, default 'pcs')
  - harga (decimal, 10,2, default 0)
  - category_type (string, default 'persediaan')
  - sub_category (string, nullable)
  - no_project (string, nullable)
  - acquisition_date (date, nullable)
  - useful_life_years (integer, nullable)
  - salvage_value (decimal, 12,2, default 0)
  - accumulated_depreciation (decimal, 12,2, default 0)
  - created_at, updated_at

### history

- Menyimpan histori transaksi stok masuk/keluar.
- Field:
  - id (primary key)
  - product_id (foreign key ke products)
  - user_id (foreign key ke users)
  - tipe_transaksi (enum: 'masuk', 'keluar')
  - jumlah (integer)
  - catatan (string, nullable)
  - created_at, updated_at

### depreciation_records

- Menyimpan histori depresiasi bulanan per barang.
- Field:
  - id (primary key)
  - product_id (foreign key ke products)
  - period (date)
  - depreciation_amount (decimal, 12,2)
  - accumulated_depreciation (decimal, 12,2)
  - book_value (decimal, 12,2)
  - created_at, updated_at
- Unique key: product_id + period

## Route Utama

- /login, /register, /logout
- /dashboard
- /products (resource CRUD)
- /transactions/barang-masuk
- /transactions/barang-keluar
- /reports/transaction-history
- /reports/export-transaction-history (CSV)
- /reports/export-transaction-history-pdf (PDF)
- /reports/nilai-aset

## Pengujian

Jalankan test dengan PHPUnit:

```bash
php artisan test
```

Test mencakup:
- Unit test untuk model dan service
- Feature test untuk route dan controller
- Integration test untuk fitur depresiasi
- Browser test untuk antarmuka pengguna

## Deployment

### Persiapan Server

1. Clone repository ke server
2. Install dependencies:

```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

3. Konfigurasi `.env` untuk production
4. Jalankan migrasi:

```bash
php artisan migrate --force
```

5. Set up queue worker (jika menggunakan fitur background):

```bash
php artisan queue:work --daemon
```

6. Konfigurasi web server (Apache/Nginx) untuk pointing ke folder `public`

### Cron Job untuk Depresiasi

Tambahkan cron job untuk pencatatan depresiasi otomatis:

```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

Di file `app/Console/Kernel.php`, sudah dikonfigurasi:

```php
$schedule->command('depreciation:record')->monthly();
```

## Data Seed Awal

Seeder menyiapkan:

- 5 akun pengguna contoh (domain ike.co.id), termasuk admin.
- Data barang lintas kategori persediaan, perlengkapan, dan peralatan.
- Data histori transaksi.
- Data depresiasi contoh per periode.

Password default akun seed: `password`

## Catatan Implementasi

- Otorisasi policy produk sudah terhubung, namun saat ini aturan policy masih mengizinkan semua user terautentikasi.
- Penghapusan barang diblokir jika barang sudah memiliki histori transaksi.
- Validasi stok memastikan tidak boleh minus pada transaksi keluar.
- Depresiasi dihitung menggunakan metode garis lurus: `(harga - salvage_value) / useful_life_years / 12`

## Kontribusi

Kontribusi selalu diterima! Ikuti langkah berikut:

1. Fork repository
2. Buat branch fitur (`git checkout -b fitur-anda`)
3. Commit perubahan (`git commit -am 'Tambah fitur baru'`)
4. Push ke branch (`git push origin fitur-anda`)
5. Buat Pull Request

## Lisensi

Proyek ini dilisensikan di bawah [Apache](LICENSE).

## Kontak

Untuk pertanyaan atau dukungan, hubungi:
- GitHub Issues: https://github.com/maliks1/assets-management/issues