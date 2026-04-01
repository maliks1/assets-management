<?php

namespace Database\Seeders;

use App\Models\DepreciationRecord;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DepreciationRecordsTableSeeder extends Seeder
{
    /**
     * Seed monthly straight-line depreciation records for depreciable assets.
     */
    public function run(): void
    {
        $periods = [
            Carbon::create(2025, 10, 1),
            Carbon::create(2025, 11, 1),
            Carbon::create(2025, 12, 1),
            Carbon::create(2026, 1, 1),
            Carbon::create(2026, 2, 1),
            Carbon::create(2026, 3, 1),
        ];

        $products = Product::where('category_type', 'perlengkapan')
            ->whereNotNull('acquisition_date')
            ->whereNotNull('useful_life_years')
            ->where('useful_life_years', '>', 0)
            ->get();

        foreach ($products as $product) {
            $monthlyDepreciation = ($product->harga - $product->salvage_value) / ($product->useful_life_years * 12);
            $monthlyDepreciation = round($monthlyDepreciation, 2);

            $accumulated = 0;

            foreach ($periods as $period) {
                if ($period->lt(Carbon::parse($product->acquisition_date)->startOfMonth())) {
                    continue;
                }

                $targetAccumulated = min(
                    $accumulated + $monthlyDepreciation,
                    $product->harga - $product->salvage_value
                );

                $depreciationAmount = $targetAccumulated - $accumulated;
                $bookValue = max($product->harga - $targetAccumulated, $product->salvage_value);

                DepreciationRecord::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'period' => $period->toDateString(),
                    ],
                    [
                        'depreciation_amount' => $depreciationAmount,
                        'accumulated_depreciation' => $targetAccumulated,
                        'book_value' => $bookValue,
                    ]
                );

                $accumulated = $targetAccumulated;
            }

            $product->update([
                'accumulated_depreciation' => $accumulated,
            ]);
        }
    }
}
