<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'deskripsi',
        'stok_saat_ini',
        'stok_minimum',
        'satuan',
        'harga',
    ];

    /**
     * Get the history records for the product.
     */
    public function history()
    {
        return $this->hasMany(History::class);
    }

    /**
     * Check if stock is low (below minimum)
     */
    public function isStockLow()
    {
        return $this->stok_saat_ini <= $this->stok_minimum;
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
}
