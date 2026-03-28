<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Web\ProductController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Product routes
    Route::resource('products', ProductController::class);

    // Transaksi Barang Masuk
    Route::get('transactions/barang-masuk', [\App\Http\Controllers\TransactionController::class, 'createBarangMasuk'])->name('transactions.barang-masuk');
    Route::post('transactions/barang-masuk', [\App\Http\Controllers\TransactionController::class, 'storeBarangMasuk'])->name('transactions.barang-masuk.store');
    
    // Transaksi Barang Keluar
    Route::get('transactions/barang-keluar', [\App\Http\Controllers\TransactionController::class, 'createBarangKeluar'])->name('transactions.barang-keluar');
    Route::post('transactions/barang-keluar', [\App\Http\Controllers\TransactionController::class, 'storeBarangKeluar'])->name('transactions.barang-keluar.store');
    
    // Laporan
    Route::get('reports/transaction-history', [\App\Http\Controllers\ReportController::class, 'transactionHistory'])->name('reports.transaction-history');
    Route::get('reports/export-transaction-history', [\App\Http\Controllers\ReportController::class, 'exportTransactionHistory'])->name('reports.export-transaction-history');
    Route::get('reports/export-transaction-history-pdf', [\App\Http\Controllers\ReportController::class, 'exportTransactionHistoryPDF'])->name('reports.export-transaction-history-pdf');
    
    // Redirect root to dashboard for authenticated users
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
});
