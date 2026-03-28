<?php

namespace App\Console\Commands;

use App\Services\DepreciationService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class RecordDepreciation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'depreciation:record {--period= : Period to record depreciation (YYYY-MM)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Record monthly depreciation for all eligible assets';

    /**
     * Execute the console command.
     */
    public function handle(DepreciationService $depreciationService): int
    {
        $this->info('Starting depreciation recording process...');

        // Parse period from option or use current month
        $period = null;
        if ($this->option('period')) {
            try {
                $period = Carbon::createFromFormat('Y-m', $this->option('period'));
                $this->info("Recording depreciation for period: {$period->format('F Y')}");
            } catch (\Exception $e) {
                $this->error('Invalid period format. Please use YYYY-MM format.');
                return Command::FAILURE;
            }
        } else {
            $period = Carbon::now();
            $this->info("Recording depreciation for current period: {$period->format('F Y')}");
        }

        try {
            $count = $depreciationService->recordDepreciationForAllProducts($period);
            
            $this->info("Successfully recorded depreciation for {$count} asset(s).");
            
            // Display summary
            $summary = $depreciationService->getDepreciationSummary();
            $this->table(
                ['Metric', 'Value'],
                [
                    ['Total Assets', $summary['total_assets']],
                    ['Total Original Value', number_format($summary['total_original_value'], 2)],
                    ['Total Accumulated Depreciation', number_format($summary['total_accumulated_depreciation'], 2)],
                    ['Total Book Value', number_format($summary['total_book_value'], 2)],
                    ['Fully Depreciated Assets', $summary['assets_fully_depreciated']],
                ]
            );

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error recording depreciation: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
