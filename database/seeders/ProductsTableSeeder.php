<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Seed product master data for PT IKE energy and electrical solutions.
     */
    public function run(): void
    {
        $products = [
            // ==========================================
            // KATEGORI: PERSEDIAAN (5 Barang)
            // Barang yang dijual atau dipasang ke klien
            // ==========================================
            [
                'kode_barang' => 'IKE-SLR-270WP',
                'nama_barang' => 'Panel Surya Monocrystalline 270Wp',
                'stok_saat_ini' => 40,
                'satuan' => 'unit',
                'harga' => 2850000,
                'category_type' => 'persediaan',
                'sub_category' => 'Solar Panel',
                'no_project' => 'CIP-2025-001',
                'acquisition_date' => null,
                'useful_life_years' => null,
                'salvage_value' => 0,
                'accumulated_depreciation' => 0,
            ],
            [
                'kode_barang' => 'IKE-INV-3KW',
                'nama_barang' => 'Inverter Off-Grid 3kW',
                'stok_saat_ini' => 10,
                'satuan' => 'unit',
                'harga' => 9750000,
                'category_type' => 'persediaan',
                'sub_category' => 'Inverter',
                'no_project' => 'HLSDV-2025-004',
                'acquisition_date' => null,
                'useful_life_years' => null,
                'salvage_value' => 0,
                'accumulated_depreciation' => 0,
            ],
            [
                'kode_barang' => 'IKE-BAT-VRLA-10AH',
                'nama_barang' => 'Baterai VRLA 10Ah 12V',
                'stok_saat_ini' => 85,
                'satuan' => 'unit',
                'harga' => 650000,
                'category_type' => 'persediaan',
                'sub_category' => 'Battery',
                'no_project' => 'CIP-HLSDV-2025',
                'acquisition_date' => null,
                'useful_life_years' => null,
                'salvage_value' => 0,
                'accumulated_depreciation' => 0,
            ],
            [
                'kode_barang' => 'IKE-IMM-HEATER-24KW',
                'nama_barang' => 'Immersion Electrical Heater 24kW',
                'stok_saat_ini' => 6,
                'satuan' => 'unit',
                'harga' => 28500000,
                'category_type' => 'persediaan',
                'sub_category' => 'Heater',
                'no_project' => 'WH-HEATER-2025-02',
                'acquisition_date' => null,
                'useful_life_years' => null,
                'salvage_value' => 0,
                'accumulated_depreciation' => 0,
            ],
            [
                'kode_barang' => 'IKE-JB-EX-DI',
                'nama_barang' => 'Junction Box EX d IIB T4',
                'stok_saat_ini' => 30,
                'satuan' => 'unit',
                'harga' => 7200000,
                'category_type' => 'persediaan',
                'sub_category' => 'Junction Box',
                'no_project' => 'CIP-2025-001',
                'acquisition_date' => null,
                'useful_life_years' => null,
                'salvage_value' => 0,
                'accumulated_depreciation' => 0,
            ],

            // ==========================================
            // KATEGORI: PERLENGKAPAN (5 Barang)
            // Barang yang habis pakai atau alat bantu K3/Testing
            // ==========================================
            [
                'kode_barang' => 'IKE-FLT-INS-500V',
                'nama_barang' => 'Insulation Resistance Tester 500V',
                'stok_saat_ini' => 4,
                'satuan' => 'unit',
                'harga' => 12500000,
                'category_type' => 'perlengkapan',
                'sub_category' => 'Testing Tools',
                'no_project' => null,
                'acquisition_date' => '2025-01-10',
                'useful_life_years' => 5,
                'salvage_value' => 1250000,
                'accumulated_depreciation' => 0,
            ],
            [
                'kode_barang' => 'IKE-FLT-THERMAL',
                'nama_barang' => 'Thermal Imaging Camera',
                'stok_saat_ini' => 2,
                'satuan' => 'unit',
                'harga' => 31500000,
                'category_type' => 'perlengkapan',
                'sub_category' => 'Testing Tools',
                'no_project' => null,
                'acquisition_date' => '2025-02-01',
                'useful_life_years' => 6,
                'salvage_value' => 2500000,
                'accumulated_depreciation' => 0,
            ],
            [
                'kode_barang' => 'IKE-FLT-GAS-DET',
                'nama_barang' => 'Portable Gas Detector 4-in-1',
                'stok_saat_ini' => 9,
                'satuan' => 'unit',
                'harga' => 6900000,
                'category_type' => 'perlengkapan',
                'sub_category' => 'HSE Equipment',
                'no_project' => null,
                'acquisition_date' => '2025-03-20',
                'useful_life_years' => 4,
                'salvage_value' => 700000,
                'accumulated_depreciation' => 0,
            ],
            [
                'kode_barang' => 'IKE-PPE-HLM-01',
                'nama_barang' => 'Helm Safety Proyek Class E',
                'stok_saat_ini' => 50,
                'satuan' => 'pcs',
                'harga' => 150000,
                'category_type' => 'perlengkapan',
                'sub_category' => 'HSE Equipment',
                'no_project' => null,
                'acquisition_date' => null,
                'useful_life_years' => null,
                'salvage_value' => 0,
                'accumulated_depreciation' => 0,
            ],
            [
                'kode_barang' => 'IKE-PPE-GLV-1KV',
                'nama_barang' => 'Electrical Insulating Gloves 1000V',
                'stok_saat_ini' => 25,
                'satuan' => 'pasang',
                'harga' => 450000,
                'category_type' => 'perlengkapan',
                'sub_category' => 'HSE Equipment',
                'no_project' => null,
                'acquisition_date' => null,
                'useful_life_years' => null,
                'salvage_value' => 0,
                'accumulated_depreciation' => 0,
            ],

            // ==========================================
            // KATEGORI: PERALATAN (5 Barang)
            // Aset tetap / mesin bantu kerja perusahaan
            // ==========================================
            [
                'kode_barang' => 'IKE-EQP-DRILL',
                'nama_barang' => 'Mesin Bor Impact Listrik 13mm',
                'stok_saat_ini' => 8,
                'satuan' => 'unit',
                'harga' => 1850000,
                'category_type' => 'peralatan',
                'sub_category' => 'Power Tools',
                'no_project' => null,
                'acquisition_date' => '2024-05-15',
                'useful_life_years' => 3,
                'salvage_value' => 200000,
                'accumulated_depreciation' => 0,
            ],
            [
                'kode_barang' => 'IKE-EQP-WELD',
                'nama_barang' => 'Mesin Las Inverter 900W',
                'stok_saat_ini' => 4,
                'satuan' => 'unit',
                'harga' => 2100000,
                'category_type' => 'peralatan',
                'sub_category' => 'Power Tools',
                'no_project' => null,
                'acquisition_date' => '2024-06-20',
                'useful_life_years' => 4,
                'salvage_value' => 300000,
                'accumulated_depreciation' => 0,
            ],
            [
                'kode_barang' => 'IKE-EQP-GENSET',
                'nama_barang' => 'Genset Portabel Bensin 3000 Watt',
                'stok_saat_ini' => 3,
                'satuan' => 'unit',
                'harga' => 5500000,
                'category_type' => 'peralatan',
                'sub_category' => 'Machinery',
                'no_project' => null,
                'acquisition_date' => '2024-01-10',
                'useful_life_years' => 5,
                'salvage_value' => 1000000,
                'accumulated_depreciation' => 0,
            ],
            [
                'kode_barang' => 'IKE-EQP-LADDER',
                'nama_barang' => 'Tangga Teleskopik Aluminium 5.2 Meter',
                'stok_saat_ini' => 10,
                'satuan' => 'unit',
                'harga' => 1200000,
                'category_type' => 'peralatan',
                'sub_category' => 'Hand Tools',
                'no_project' => null,
                'acquisition_date' => '2023-11-05',
                'useful_life_years' => 5,
                'salvage_value' => 150000,
                'accumulated_depreciation' => 0,
            ],
            [
                'kode_barang' => 'IKE-EQP-AC',
                'nama_barang' => 'AC Split 1 PK Standar',
                'stok_saat_ini' => 5,
                'satuan' => 'unit',
                'harga' => 3500000,
                'category_type' => 'peralatan',
                'sub_category' => 'Office Equipment',
                'no_project' => null,
                'acquisition_date' => '2024-08-12',
                'useful_life_years' => 4,
                'salvage_value' => 500000,
                'accumulated_depreciation' => 0,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['kode_barang' => $product['kode_barang']],
                $product
            );
        }
    }
}