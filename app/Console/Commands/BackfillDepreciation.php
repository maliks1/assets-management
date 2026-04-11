<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\DepreciationService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BackfillDepreciation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'depreciation:backfill {--start= : Start period (YYYY-MM)} {--end= : End period (YYYY-MM)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill monthly depreciation records for all eligible assets.';

    /**
     * Execute the console command.
     */
    public function handle(DepreciationService $depreciationService): int
    {
        $startPeriod = $this->resolveStartPeriod();

        if (!$startPeriod) {
            $this->warn('No eligible peralatan assets with acquisition date were found.');
            return Command::SUCCESS;
        }

        $endPeriod = $this->resolveEndPeriod();

        if ($endPeriod->lt($startPeriod)) {
            $this->error('End period cannot be earlier than start period.');
            return Command::FAILURE;
        }

        $this->info(sprintf(
            'Backfilling depreciation from %s to %s...',
            $startPeriod->format('Y-m'),
            $endPeriod->format('Y-m')
        ));

        $totalRecorded = 0;
        $periods = 0;

        for ($period = $startPeriod->copy(); $period->lte($endPeriod); $period->addMonth()) {
            $recorded = $depreciationService->recordDepreciationForAllProducts($period->copy());
            $periods++;
            $totalRecorded += $recorded;

            $this->line(sprintf('%s: %d asset(s) processed', $period->format('Y-m'), $recorded));
        }

        $this->info(sprintf(
            'Completed backfill for %d period(s). Total recorded entries: %d.',
            $periods,
            $totalRecorded
        ));

        return Command::SUCCESS;
    }

    private function resolveStartPeriod(): ?Carbon
    {
        $startOption = $this->option('start');

        if ($startOption) {
            try {
                return Carbon::createFromFormat('Y-m', $startOption)->startOfMonth();
            } catch (\Exception $exception) {
                $this->error('Invalid start format. Please use YYYY-MM.');
                return null;
            }
        }

        $earliestAcquisitionDate = Product::where('category_type', 'peralatan')
            ->whereNotNull('acquisition_date')
            ->min('acquisition_date');

        if (!$earliestAcquisitionDate) {
            return null;
        }

        return Carbon::parse($earliestAcquisitionDate)->startOfMonth();
    }

    private function resolveEndPeriod(): Carbon
    {
        $endOption = $this->option('end');

        if (!$endOption) {
            return Carbon::now()->startOfMonth();
        }

        try {
            return Carbon::createFromFormat('Y-m', $endOption)->startOfMonth();
        } catch (\Exception $exception) {
            $this->error('Invalid end format. Please use YYYY-MM. Falling back to current month.');
            return Carbon::now()->startOfMonth();
        }
    }
}
