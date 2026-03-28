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
        Schema::table('products', function (Blueprint $table) {
            // Category fields
            $table->string('category_type')->default('persediaan')->after('satuan');
            $table->string('sub_category')->nullable()->after('category_type');
            $table->string('project_name')->nullable()->after('sub_category');
            
            // Depreciation fields for equipment
            $table->date('acquisition_date')->nullable()->after('project_name');
            $table->integer('useful_life_years')->nullable()->after('acquisition_date');
            $table->decimal('salvage_value', 12, 2)->default(0)->after('useful_life_years');
            $table->decimal('accumulated_depreciation', 12, 2)->default(0)->after('salvage_value');
            
            // Index for filtering
            $table->index('category_type');
            $table->index('sub_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['category_type']);
            $table->dropIndex(['sub_category']);
            $table->dropColumn([
                'category_type',
                'sub_category',
                'project_name',
                'acquisition_date',
                'useful_life_years',
                'salvage_value',
                'accumulated_depreciation',
            ]);
        });
    }
};