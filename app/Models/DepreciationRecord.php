<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepreciationRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'period',
        'depreciation_amount',
        'accumulated_depreciation',
        'book_value',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'period' => 'date',
        'depreciation_amount' => 'decimal:2',
        'accumulated_depreciation' => 'decimal:2',
        'book_value' => 'decimal:2',
    ];

    /**
     * Get the product that owns the depreciation record.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope to filter by period
     */
    public function scopeForPeriod($query, $period)
    {
        return $query->whereDate('period', $period);
    }

    /**
     * Scope to order by period descending
     */
    public function scopeLatestPeriod($query)
    {
        return $query->orderByDesc('period');
    }
}