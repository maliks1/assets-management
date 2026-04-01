<?php

namespace Database\Seeders;

use App\Models\History;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class HistoryTableSeeder extends Seeder
{
    /**
     * Seed transaction history for procurement and project deployment.
     */
    public function run(): void
    {
        $warehouseLead = User::where('email', 'warehouse@ike.co.id')->first();
        $fieldEngineer = User::where('email', 'engineer@ike.co.id')->first();

        if (!$warehouseLead || !$fieldEngineer) {
            return;
        }

        $transactions = [
            [
                'kode_barang' => 'IKE-SLR-270WP',
                'tipe_transaksi' => 'masuk',
                'jumlah' => 50,
                'catatan' => 'Pengadaan awal modul panel surya untuk proyek CIP dan HLSDV.',
                'user_id' => $warehouseLead->id,
            ],
            [
                'kode_barang' => 'IKE-INV-1KW',
                'tipe_transaksi' => 'masuk',
                'jumlah' => 15,
                'catatan' => 'Barang masuk inverter 1kW untuk integrasi Chemical Injection Package.',
                'user_id' => $warehouseLead->id,
            ],
            [
                'kode_barang' => 'IKE-INV-3KW',
                'tipe_transaksi' => 'masuk',
                'jumlah' => 12,
                'catatan' => 'Stok inverter 3kW diterima untuk kebutuhan HLSDV.',
                'user_id' => $warehouseLead->id,
            ],
            [
                'kode_barang' => 'IKE-BAT-VRLA-10AH',
                'tipe_transaksi' => 'masuk',
                'jumlah' => 100,
                'catatan' => 'Penerimaan baterai VRLA 10Ah 12V untuk dua paket proyek 2025.',
                'user_id' => $warehouseLead->id,
            ],
            [
                'kode_barang' => 'IKE-SLR-270WP',
                'tipe_transaksi' => 'keluar',
                'jumlah' => 10,
                'catatan' => 'Deploy ke lokasi CIP 2025 untuk instalasi Solar Panel Package.',
                'user_id' => $fieldEngineer->id,
            ],
            [
                'kode_barang' => 'IKE-INV-1KW',
                'tipe_transaksi' => 'keluar',
                'jumlah' => 3,
                'catatan' => 'Pemasangan inverter 1kW pada paket CIP.',
                'user_id' => $fieldEngineer->id,
            ],
            [
                'kode_barang' => 'IKE-SLR-270WP',
                'tipe_transaksi' => 'keluar',
                'jumlah' => 8,
                'catatan' => 'Deploy modul panel surya ke lokasi HLSDV.',
                'user_id' => $fieldEngineer->id,
            ],
            [
                'kode_barang' => 'IKE-INV-3KW',
                'tipe_transaksi' => 'keluar',
                'jumlah' => 2,
                'catatan' => 'Pemasangan inverter 3kW pada sistem HLSDV.',
                'user_id' => $fieldEngineer->id,
            ],
            [
                'kode_barang' => 'IKE-BAT-VRLA-10AH',
                'tipe_transaksi' => 'keluar',
                'jumlah' => 20,
                'catatan' => 'Baterai dipasang untuk commissioning CIP dan HLSDV.',
                'user_id' => $fieldEngineer->id,
            ],
        ];

        foreach ($transactions as $transaction) {
            $product = Product::where('kode_barang', $transaction['kode_barang'])->first();

            if (!$product) {
                continue;
            }

            History::create([
                'product_id' => $product->id,
                'user_id' => $transaction['user_id'],
                'tipe_transaksi' => $transaction['tipe_transaksi'],
                'jumlah' => $transaction['jumlah'],
                'catatan' => $transaction['catatan'],
            ]);
        }
    }
}
