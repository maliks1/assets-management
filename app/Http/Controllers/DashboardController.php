<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     */
    public function index()
    {
        $totalProducts = Product::count();
        $totalStock = Product::sum('stok_saat_ini');
        $lowStockProducts = Product::whereColumn('stok_saat_ini', '<=', 'stok_minimum')->orderBy('stok_saat_ini')->get();
        $recentTransactions = History::with('product')->orderBy('created_at', 'desc')->limit(5)->get();
        
        // Hitung total nilai stok
        $totalStockValue = Product::sum(DB::raw('stok_saat_ini * harga'));

        return view('dashboard', compact(
            'totalProducts',
            'totalStock',
            'lowStockProducts',
            'recentTransactions',
            'totalStockValue'
        ));
    }
}