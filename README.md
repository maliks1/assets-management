# Sistem Gudang Laravel

Sistem manajemen gudang yang dibangun dengan Laravel dan Bootstrap untuk mengelola produk, stok, dan riwayat transaksi.

## Fitur Utama

- **Autentikasi**: Login, register, dan logout dengan sistem keamanan Laravel
- **Dashboard**: Statistik real-time untuk monitoring gudang
- **Manajemen Produk**: CRUD operasi untuk produk dengan tracking stok
- **Riwayat Transaksi**: Pencatatan transaksi masuk dan keluar
- **Notifikasi Stok**: Peringatan otomatis untuk stok yang menipis
- **Responsive Design**: Interface yang responsif dengan Bootstrap 5

## Teknologi yang Digunakan

- **Backend**: Laravel 12
- **Database**: MySQL
- **Frontend**: Bootstrap 5, Bootstrap Icons
- **Authentication**: Laravel built-in authentication
- **PHP**: 8.2+

## Instalasi dan Setup

### Prerequisites
- PHP 8.2 atau lebih tinggi
- Composer
- MySQL 5.7 atau lebih tinggi
- Node.js dan NPM (untuk asset compilation)

### Langkah-langkah Instalasi

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd web-gudang
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database**
   Edit file `.env` dan sesuaikan konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=web_gudang
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

5. **Buat database**
   Buat database MySQL dengan nama `web_gudang`

6. **Jalankan migrasi dan seeder**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Compile assets (opsional)**
   ```bash
   npm run dev
   ```

8. **Jalankan server**
   ```bash
   php artisan serve
   ```

Aplikasi akan berjalan di `http://localhost:8000`

## Data Default

Setelah menjalankan seeder, Anda akan memiliki:

### User Admin
- Email: `admin@example.com`
- Password: `password`

### Produk Contoh
- Laptop Asus ROG (Stok: 10)
- Mouse Gaming (Stok: 25)
- Keyboard Mechanical (Stok: 3)
- Monitor 24 inch (Stok: 8)
- Headset Gaming (Stok: 2)

## Struktur Database

### Tabel `users`
- `id` (primary key)
- `name` (string)
- `email` (string, unique)
- `password` (string, hashed)
- `remember_token`
- `created_at`, `updated_at`

### Tabel `products`
- `id` (primary key)
- `kode_barang` (string, unique)
- `nama_barang` (string)
- `deskripsi` (text, nullable)
- `stok_saat_ini` (integer, default 0)
- `stok_minimum` (integer, default 5)
- `created_at`, `updated_at`

### Tabel `history`
- `id` (primary key)
- `product_id` (foreign key ke products)
- `user_id` (foreign key ke users)
- `tipe_transaksi` (enum: 'masuk', 'keluar')
- `jumlah` (integer)
- `catatan` (string, nullable)
- `created_at`, `updated_at`

## Relasi Database

- **Product** hasMany **History**
- **History** belongsTo **Product**
- **History** belongsTo **User**
- **User** hasMany **History**

## Fitur Dashboard

Dashboard menampilkan:
- Total produk
- Statistik stok aman dan menipis
- Daftar produk dengan stok menipis
- Riwayat transaksi terbaru

## Keamanan

- Password di-hash menggunakan bcrypt
- CSRF protection pada semua form
- Validasi input pada semua endpoint
- Middleware authentication untuk route yang dilindungi

## Contributing

1. Fork repository
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## License

Proyek ini menggunakan license Apache. Lihat file `LICENSE` untuk detail lebih lanjut.

## Support

Jika ada pertanyaan atau masalah, silakan buat issue di repository ini.
