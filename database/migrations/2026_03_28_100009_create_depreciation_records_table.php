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
        Schema::create('depreciation_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->date('period');
            $table->decimal('depreciation_amount', 12, 2);
            $table->decimal('accumulated_depreciation', 12, 2);
            $table->decimal('book_value', 12, 2);
            $table->timestamps();
            
            $table->unique(['product_id', 'period'], 'unique_product_period');
            $table->index('period');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depreciation_records');
    }
};