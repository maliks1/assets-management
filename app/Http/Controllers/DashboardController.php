<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     */
    public function index()
    {
        $totalProducts = Product::count();
        $totalStock = Product::sum('stok_saat_ini');
        $recentTransactions = History::with('product')->orderBy('created_at', 'desc')->limit(5)->get();

        // Hitung total nilai stok
        $totalStockValue = Product::sum(DB::raw('stok_saat_ini * harga'));

        $categorySummary = Product::select('category_type', DB::raw('COUNT(*) as total_items'), DB::raw('SUM(stok_saat_ini) as total_stock'))
            ->groupBy('category_type')
            ->get()
            ->keyBy('category_type');

        $todayTransactionSummary = History::select('tipe_transaksi', DB::raw('COUNT(*) as total_transactions'), DB::raw('SUM(jumlah) as total_quantity'))
            ->whereDate('created_at', Carbon::today())
            ->groupBy('tipe_transaksi')
            ->get()
            ->keyBy('tipe_transaksi');

        $categoryOrder = ['persediaan', 'perlengkapan', 'peralatan'];

        $formattedCategorySummary = collect($categoryOrder)->map(function ($category) use ($categorySummary) {
            $data = $categorySummary->get($category);

            return [
                'label' => ucfirst($category),
                'total_items' => (int) ($data->total_items ?? 0),
                'total_stock' => (int) ($data->total_stock ?? 0),
            ];
        });

        $todayTransactions = [
            'masuk' => [
                'total_transactions' => (int) ($todayTransactionSummary->get('masuk')->total_transactions ?? 0),
                'total_quantity' => (int) ($todayTransactionSummary->get('masuk')->total_quantity ?? 0),
            ],
            'keluar' => [
                'total_transactions' => (int) ($todayTransactionSummary->get('keluar')->total_transactions ?? 0),
                'total_quantity' => (int) ($todayTransactionSummary->get('keluar')->total_quantity ?? 0),
            ],
        ];

        return view('dashboard', compact(
            'totalProducts',
            'totalStock',
            'recentTransactions',
            'totalStockValue',
            'formattedCategorySummary',
            'todayTransactions'
        ));
    }
}