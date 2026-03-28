<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create sample products
        Product::create([
            'kode_barang' => 'PRD001',
            'nama_barang' => 'Laptop Gaming',
            'deskripsi' => 'Laptop gaming dengan performa tinggi',
            'stok_saat_ini' => 10,
            'stok_minimum' => 5,
            'satuan' => 'pcs',
            'harga' => 15000000,
        ]);

        Product::create([
            'kode_barang' => 'PRD002',
            'nama_barang' => 'Mouse Gaming',
            'deskripsi' => 'Mouse gaming dengan sensor optical',
            'stok_saat_ini' => 25,
            'stok_minimum' => 10,
            'satuan' => 'pcs',
            'harga' => 500000,
        ]);

        Product::create([
            'kode_barang' => 'PRD003',
            'nama_barang' => 'Keyboard Mechanical',
            'deskripsi' => 'Keyboard mechanical dengan switch blue',
            'stok_saat_ini' => 3,
            'stok_minimum' => 5,
            'satuan' => 'pcs',
            'harga' => 1200000,
        ]);

        Product::create([
            'kode_barang' => 'PRD004',
            'nama_barang' => 'Monitor 24 inch',
            'deskripsi' => 'Monitor LED 24 inch Full HD',
            'stok_saat_ini' => 8,
            'stok_minimum' => 3,
            'satuan' => 'pcs',
            'harga' => 2500000,
        ]);

        Product::create([
            'kode_barang' => 'PRD005',
            'nama_barang' => 'Headset Gaming',
            'deskripsi' => 'Headset gaming dengan microphone',
            'stok_saat_ini' => 2,
            'stok_minimum' => 5,
            'satuan' => 'pcs',
            'harga' => 800000,
        ]);

        Product::create([
            'kode_barang' => 'PRD006',
            'nama_barang' => 'Webcam HD',
            'deskripsi' => 'Webcam dengan resolusi HD 1080p',
            'stok_saat_ini' => 15,
            'stok_minimum' => 5,
            'satuan' => 'pcs',
            'harga' => 450000,
        ]);

        Product::create([
            'kode_barang' => 'PRD007',
            'nama_barang' => 'Speaker Bluetooth',
            'deskripsi' => 'Speaker portable dengan koneksi bluetooth',
            'stok_saat_ini' => 12,
            'stok_minimum' => 3,
            'satuan' => 'pcs',
            'harga' => 750000,
        ]);

        Product::create([
            'kode_barang' => 'PRD008',
            'nama_barang' => 'Charger Laptop',
            'deskripsi' => 'Charger laptop universal 65W',
            'stok_saat_ini' => 20,
            'stok_minimum' => 5,
            'satuan' => 'pcs',
            'harga' => 350000,
        ]);

        Product::create([
            'kode_barang' => 'PRD009',
            'nama_barang' => 'SSD 1TB',
            'deskripsi' => 'Solid State Drive kapasitas 1TB',
            'stok_saat_ini' => 7,
            'stok_minimum' => 3,
            'satuan' => 'pcs',
            'harga' => 2200000,
        ]);

        Product::create([
            'kode_barang' => 'PRD010',
            'nama_barang' => 'RAM 16GB',
            'deskripsi' => 'Memory RAM DDR4 16GB (2x8GB)',
            'stok_saat_ini' => 9,
            'stok_minimum' => 4,
            'satuan' => 'pcs',
            'harga' => 1100000,
        ]);

        Product::create([
            'kode_barang' => 'PRD011',
            'nama_barang' => 'Cooling Pad',
            'deskripsi' => 'Cooling pad untuk laptop dengan 3 kipas',
            'stok_saat_ini' => 18,
            'stok_minimum' => 5,
            'satuan' => 'pcs',
            'harga' => 280000,
        ]);

        Product::create([
            'kode_barang' => 'PRD012',
            'nama_barang' => 'UPS 1000VA',
            'deskripsi' => 'Unit Power Supply cadangan 1000VA',
            'stok_saat_ini' => 5,
            'stok_minimum' => 2,
            'satuan' => 'pcs',
            'harga' => 1800000,
        ]);

        Product::create([
            'kode_barang' => 'PRD013',
            'nama_barang' => 'Router WiFi 6',
            'deskripsi' => 'Router wireless dengan teknologi WiFi 6',
            'stok_saat_ini' => 8,
            'stok_minimum' => 3,
            'satuan' => 'pcs',
            'harga' => 950000,
        ]);

        Product::create([
            'kode_barang' => 'PRD014',
            'nama_barang' => 'External HDD 2TB',
            'deskripsi' => 'Harddisk eksternal kapasitas 2TB',
            'stok_saat_ini' => 11,
            'stok_minimum' => 4,
            'satuan' => 'pcs',
            'harga' => 1350000,
        ]);

        Product::create([
            'kode_barang' => 'PRD015',
            'nama_barang' => 'Gaming Chair',
            'deskripsi' => 'Kursi gaming ergonomis dengan sandaran punggung',
            'stok_saat_ini' => 4,
            'stok_minimum' => 2,
            'satuan' => 'pcs',
            'harga' => 3200000,
        ]);

        Product::create([
            'kode_barang' => 'PRD016',
            'nama_barang' => 'Smartphone Flagship',
            'deskripsi' => 'Smartphone flagship terbaru dengan kamera canggih',
            'stok_saat_ini' => 6,
            'stok_minimum' => 3,
            'satuan' => 'pcs',
            'harga' => 12500000,
        ]);

        Product::create([
            'kode_barang' => 'PRD017',
            'nama_barang' => 'Tablet 10 inch',
            'deskripsi' => 'Tablet dengan layar 10 inch dan stylus pen',
            'stok_saat_ini' => 9,
            'stok_minimum' => 4,
            'satuan' => 'pcs',
            'harga' => 4800000,
        ]);

        Product::create([
            'kode_barang' => 'PRD018',
            'nama_barang' => 'Power Bank 20000mAh',
            'deskripsi' => 'Power bank kapasitas besar 20000mAh fast charging',
            'stok_saat_ini' => 22,
            'stok_minimum' => 8,
            'satuan' => 'pcs',
            'harga' => 220000,
        ]);

        Product::create([
            'kode_barang' => 'PRD019',
            'nama_barang' => 'Wireless Earbuds',
            'deskripsi' => 'Earbuds nirkabel dengan noise cancellation',
            'stok_saat_ini' => 14,
            'stok_minimum' => 6,
            'satuan' => 'pcs',
            'harga' => 1650000,
        ]);

        Product::create([
            'kode_barang' => 'PRD020',
            'nama_barang' => 'Smart Watch',
            'deskripsi' => 'Jam tangan pintar dengan health monitoring',
            'stok_saat_ini' => 7,
            'stok_minimum' => 3,
            'satuan' => 'pcs',
            'harga' => 2900000,
        ]);
    }
}
