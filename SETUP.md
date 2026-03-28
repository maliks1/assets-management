# Setup Proyek Sistem Gudang Laravel

## Persyaratan Sistem
- PHP 8.2 atau lebih tinggi
- Composer
- MySQL 5.7 atau lebih tinggi
- Node.js dan NPM (untuk asset compilation)

## Langkah-langkah Setup

### 1. Clone dan Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 2. Konfigurasi Environment
```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Konfigurasi Database
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_gudang
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Buat Database
Buat database MySQL dengan nama `web_gudang`

### 5. Jalankan Migrasi
```bash
php artisan migrate
```

### 6. Compile Assets (Opsional)
```bash
npm run dev
```

### 7. Jalankan Server
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## Fitur yang Tersedia

### Autentikasi
- Login dengan email dan password
- Register user baru
- Logout

### Dashboard
- Statistik total produk
- Statistik stok aman dan menipis
- Daftar produk dengan stok menipis
- Riwayat transaksi terbaru

### Model dan Relasi
- **Product**: Model untuk produk dengan kolom kode_barang, nama_barang, deskripsi, stok_saat_ini, stok_minimum
- **History**: Model untuk riwayat transaksi dengan relasi ke Product dan User
- **User**: Model user dengan relasi ke History

### Relasi Database
- Product hasMany History
- History belongsTo Product
- History belongsTo User
- User hasMany History

## Struktur Database

### Tabel products
- id (primary key)
- kode_barang (string, unique)
- nama_barang (string)
- deskripsi (text, nullable)
- stok_saat_ini (integer, default 0)
- stok_minimum (integer, default 5)
- created_at, updated_at

### Tabel history
- id (primary key)
- product_id (foreign key ke products)
- user_id (foreign key ke users)
- tipe_transaksi (enum: 'masuk', 'keluar')
- jumlah (integer)
- catatan (string, nullable)
- created_at, updated_at

### Tabel users
- id (primary key)
- name (string)
- email (string, unique)
- password (string, hashed)
- remember_token
- created_at, updated_at 