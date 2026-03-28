<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'tipe_transaksi',
        'jumlah',
        'catatan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tipe_transaksi' => 'string',
        'jumlah' => 'integer',
    ];

    /**
     * Get the product that owns the history.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that owns the history.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for masuk transactions
     */
    public function scopeMasuk($query)
    {
        return $query->where('tipe_transaksi', 'masuk');
    }

    /**
     * Scope for keluar transactions
     */
    public function scopeKeluar($query)
    {
        return $query->where('tipe_transaksi', 'keluar');
    }
} 