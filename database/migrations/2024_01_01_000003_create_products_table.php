<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->text('deskripsi')->nullable();
            $table->integer('stok_saat_ini')->default(0);
            $table->integer('stok_minimum')->default(5);
            $table->string('satuan')->default('pcs');
            $table->decimal('harga', 10, 2)->default(0);
            $table->string('category_type')->default('persediaan');
            $table->string('sub_category')->nullable();
            $table->string('no_proyek')->nullable();
            $table->date('acquisition_date')->nullable();
            $table->integer('useful_life_years')->nullable();
            $table->decimal('salvage_value', 12, 2)->default(0);
            $table->decimal('accumulated_depreciation', 12, 2)->default(0);
            $table->timestamps();
            
            // Indexes for filtering
            $table->index('category_type');
            $table->index('sub_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};