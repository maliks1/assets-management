<?php

namespace App\Services;

use App\Models\Product;
use App\Models\DepreciationRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DepreciationService
{
    /**
     * Calculate monthly depreciation for a product using straight-line method
     */
    public function calculateMonthlyDepreciation(Product $product): float
    {
        if (!$this->canDepreciate($product)) {
            return 0;
        }

        $annualDepreciation = $this->calculateAnnualDepreciation($product);
        return $annualDepreciation / 12;
    }

    /**
     * Calculate annual depreciation using straight-line method
     */
    public function calculateAnnualDepreciation(Product $product): float
    {
        if (!$this->canDepreciate($product)) {
            return 0;
        }

        $depreciableAmount = $product->harga - $product->salvage_value;
        return $depreciableAmount / $product->useful_life_years;
    }

    /**
     * Check if a product can be depreciated
     */
    public function canDepreciate(Product $product): bool
    {
        return $product->category_type === 'peralatan' 
            && $product->acquisition_date !== null
            && $product->useful_life_years !== null
            && $product->useful_life_years > 0
            && !$product->isFullyDepreciated();
    }

    /**
     * Record monthly depreciation for a product
     */
    public function recordMonthlyDepreciation(Product $product, ?Carbon $period = null): ?DepreciationRecord
    {
        if (!$this->canDepreciate($product)) {
            return null;
        }

        $period = $period ?? Carbon::now();
        if (!$this->isPeriodEligible($product, $period)) {
            return null;
        }
        $periodString = $period->format('Y-m-01'); // First day of month

        // Check if already recorded for this period
        $existing = DepreciationRecord::where('product_id', $product->id)
            ->whereDate('period', $periodString)
            ->first();

        if ($existing) {
            return $existing;
        }

        $monthlyDepreciation = $this->calculateMonthlyDepreciation($product);
        
        if ($monthlyDepreciation <= 0) {
            return null;
        }

        $newAccumulatedDepreciation = $product->accumulated_depreciation + $monthlyDepreciation;
        $bookValue = $product->harga - $newAccumulatedDepreciation;

        // Ensure book value doesn't go below salvage value
        if ($bookValue < $product->salvage_value) {
            $monthlyDepreciation = $product->harga - $product->salvage_value - $product->accumulated_depreciation;
            $newAccumulatedDepreciation = $product->harga - $product->salvage_value;
            $bookValue = $product->salvage_value;
        }

        DB::beginTransaction();
        try {
            // Create depreciation record
            $depreciationRecord = DepreciationRecord::create([
                'product_id' => $product->id,
                'period' => $periodString,
                'depreciation_amount' => $monthlyDepreciation,
                'accumulated_depreciation' => $newAccumulatedDepreciation,
                'book_value' => max($bookValue, $product->salvage_value),
            ]);

            // Update product's accumulated depreciation
            $product->increment('accumulated_depreciation', $monthlyDepreciation);

            DB::commit();
            return $depreciationRecord;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Record depreciation for all eligible products
     */
    public function recordDepreciationForAllProducts(?Carbon $period = null): int
    {
        $period = $period ?? Carbon::now();
        $periodMonth = $period->copy()->startOfMonth();

        $products = Product::where('category_type', 'peralatan')
            ->whereNotNull('acquisition_date')
            ->whereNotNull('useful_life_years')
            ->whereDate('acquisition_date', '<=', $periodMonth->toDateString())
            ->get();

        $count = 0;
        /** @var Product $product */
        foreach ($products as $product) {
            if ($this->recordMonthlyDepreciation($product, $period)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Ensure a product has depreciation records from acquisition month through target month.
     */
    public function catchUpDepreciation(Product $product, ?Carbon $targetPeriod = null): int
    {
        if (!$this->canDepreciate($product) || !$product->acquisition_date) {
            return 0;
        }

        $targetPeriod = ($targetPeriod ?? Carbon::now())->copy()->startOfMonth();
        $acquisitionMonth = Carbon::parse($product->acquisition_date)->startOfMonth();

        if ($targetPeriod->lt($acquisitionMonth)) {
            return 0;
        }

        $created = 0;
        for ($period = $acquisitionMonth->copy(); $period->lte($targetPeriod); $period->addMonth()) {
            if ($this->recordMonthlyDepreciation($product, $period->copy())) {
                $created++;
                $product->refresh();
            }
        }

        return $created;
    }

    /**
     * Depreciation starts in acquisition month (full-month convention).
     */
    private function isPeriodEligible(Product $product, Carbon $period): bool
    {
        if (!$product->acquisition_date) {
            return false;
        }

        $acquisitionMonth = Carbon::parse($product->acquisition_date)->startOfMonth();
        return $period->copy()->startOfMonth()->gte($acquisitionMonth);
    }

    /**
     * Get depreciation schedule for a product
     */
    public function getDepreciationSchedule(Product $product): array
    {
        if (!$this->canDepreciate($product)) {
            return [];
        }

        $schedule = [];
        $acquisitionDate = Carbon::parse($product->acquisition_date);
        $totalMonths = $product->useful_life_years * 12;
        $monthlyDepreciation = $this->calculateMonthlyDepreciation($product);

        for ($monthIndex = 0; $monthIndex < $totalMonths; $monthIndex++) {
            $period = (clone $acquisitionDate)->addMonths($monthIndex);
            $periodString = $period->format('Y-m-01');

            // Check if already recorded
            $existing = DepreciationRecord::where('product_id', $product->id)
                ->whereDate('period', $periodString)
                ->first();

            $accumulatedDepreciation = $monthlyDepreciation * ($monthIndex + 1);
            $bookValue = $product->harga - $accumulatedDepreciation;

            $schedule[] = [
                'period' => $periodString,
                'depreciation_amount' => $monthlyDepreciation,
                'accumulated_depreciation' => min($accumulatedDepreciation, $product->harga - $product->salvage_value),
                'book_value' => max($bookValue, $product->salvage_value),
                'is_recorded' => $existing !== null,
            ];
        }

        return $schedule;
    }

    /**
     * Get total depreciation for a specific period
     */
    public function getTotalDepreciationForPeriod(Carbon $period): float
    {
        return DepreciationRecord::whereDate('period', $period->format('Y-m-01'))
            ->sum('depreciation_amount');
    }

    /**
     * Get depreciation summary
     */
    public function getDepreciationSummary(): array
    {
        $products = Product::where('category_type', 'peralatan')
            ->whereNotNull('acquisition_date')
            ->whereNotNull('useful_life_years')
            ->get();

        $summary = [
            'total_assets' => $products->count(),
            'total_original_value' => 0,
            'total_accumulated_depreciation' => 0,
            'total_book_value' => 0,
            'assets_fully_depreciated' => 0,
        ];

        /** @var Product $product */
        foreach ($products as $product) {
            $summary['total_original_value'] += $product->harga;
            $summary['total_accumulated_depreciation'] += $product->accumulated_depreciation;
            $summary['total_book_value'] += ($product->harga - $product->accumulated_depreciation);
            
            if ($product->isFullyDepreciated()) {
                $summary['assets_fully_depreciated']++;
            }
        }

        return $summary;
    }
}
