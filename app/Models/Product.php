<?php

namespace App\Models;

use App\Models\History;
use App\Models\DepreciationRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'stok_saat_ini',
        'satuan',
        'harga',
        'category_type',
        'sub_category',
        'no_project',
        'acquisition_date',
        'useful_life_years',
        'salvage_value',
        'accumulated_depreciation',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'acquisition_date' => 'date',
        'useful_life_years' => 'integer',
        'salvage_value' => 'decimal:2',
        'accumulated_depreciation' => 'decimal:2',
        'harga' => 'decimal:2',
    ];

    /**
     * Get the history records for the product.
     */
    public function history()
    {
        return $this->hasMany(History::class);
    }

    /**
     * Get the depreciation records for the product.
     */
    public function depreciationRecords()
    {
        return $this->hasMany(DepreciationRecord::class);
    }

    /**
     * Add stock (for masuk transaction)
     */
    public function addStock($jumlah)
    {
        $this->increment('stok_saat_ini', $jumlah);
    }

    /**
     * Reduce stock (for keluar transaction)
     */
    public function reduceStock($jumlah)
    {
        if ($this->stok_saat_ini >= $jumlah) {
            $this->decrement('stok_saat_ini', $jumlah);
            return true;
        }
        return false;
    }

    /**
     * Calculate annual depreciation using straight-line method
     */
    public function calculateAnnualDepreciation()
    {
        if (!$this->acquisition_date || !$this->useful_life_years || $this->useful_life_years <= 0) {
            return 0;
        }

        $depreciable_amount = $this->harga - $this->salvage_value;
        return $depreciable_amount / $this->useful_life_years;
    }

    /**
     * Calculate monthly depreciation
     */
    public function calculateMonthlyDepreciation()
    {
        return $this->calculateAnnualDepreciation() / 12;
    }

    /**
     * Get current book value
     */
    public function getBookValueAttribute()
    {
        return $this->harga - $this->accumulated_depreciation;
    }

    /**
     * Check if asset is fully depreciated
     */
    public function isFullyDepreciated()
    {
        return $this->accumulated_depreciation >= ($this->harga - $this->salvage_value);
    }
}
