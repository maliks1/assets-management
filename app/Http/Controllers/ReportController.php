<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ReportController extends Controller
{
    /**
     * Show transaction history report
     */
    public function transactionHistory(Request $request)
    {
        $query = History::with(['product', 'user']);

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Filter by transaction type
        if ($request->filled('transaction_type') && $request->transaction_type !== 'all') {
            $query->where('tipe_transaksi', $request->transaction_type);
        }

        // Filter by product
        if ($request->filled('product_id') && $request->product_id !== 'all') {
            $query->where('product_id', $request->product_id);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(20);
        $products = Product::orderBy('kode_barang')->get();

        return view('reports.transaction-history', compact('transactions', 'products'));
    }

    /**
     * Export transaction history to CSV
     */
    public function exportTransactionHistory(Request $request)
    {
        $query = History::with(['product', 'user']);

        // Apply same filters as view
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        if ($request->filled('transaction_type') && $request->transaction_type !== 'all') {
            $query->where('tipe_transaksi', $request->transaction_type);
        }

        if ($request->filled('product_id') && $request->product_id !== 'all') {
            $query->where('product_id', $request->product_id);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        $filename = 'laporan_transaksi_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'Tanggal',
                'Kode Barang',
                'Nama Barang', 
                'Tipe Transaksi',
                'Jumlah',
                'Dicatat Oleh',
                'Catatan'
            ]);

            // Add data rows
            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->created_at->format('d/m/Y H:i'),
                    $transaction->product->kode_barang ?? '-',
                    $transaction->product->nama_barang ?? '-',
                    $transaction->tipe_transaksi,
                    $transaction->jumlah,
                    $transaction->user->name ?? '-',
                    $transaction->catatan ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Export transaction history to PDF
     */
    public function exportTransactionHistoryPDF(Request $request)
    {
        $query = History::with(['product', 'user']);

        // Apply same filters as view
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        if ($request->filled('transaction_type') && $request->transaction_type !== 'all') {
            $query->where('tipe_transaksi', $request->transaction_type);
        }

        if ($request->filled('product_id') && $request->product_id !== 'all') {
            $query->where('product_id', $request->product_id);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();
        
        // Judul laporan
        $title = 'Laporan Histori Transaksi';
        
        // Filter info untuk ditampilkan di PDF
        $filterInfo = [];
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $filterInfo[] = 'Periode: ' . $request->start_date . ' s/d ' . $request->end_date;
        }
        
        if ($request->filled('transaction_type') && $request->transaction_type !== 'all') {
            $filterInfo[] = 'Tipe Transaksi: ' . ucfirst($request->transaction_type);
        }
        
        if ($request->filled('product_id') && $request->product_id !== 'all') {
            $product = Product::find($request->product_id);
            if ($product) {
                $filterInfo[] = 'Produk: ' . $product->kode_barang . ' - ' . $product->nama_barang;
            }
        }
        
        $pdf = PDF::loadView('reports.transaction-history-pdf', [
            'transactions' => $transactions,
            'title' => $title,
            'filterInfo' => $filterInfo,
            'date' => date('d/m/Y H:i:s')
        ]);
        
        return $pdf->download('laporan_transaksi_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}