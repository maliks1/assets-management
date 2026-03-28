<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Show form barang masuk
     */
    public function createBarangMasuk()
    {
        $products = Product::orderBy('kode_barang')->get();
        return view('transactions.barang-masuk', compact('products'));
    }

    /**
     * Store barang masuk
     */
    public function storeBarangMasuk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'jumlah' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ], [
            'product_id.required' => 'Produk wajib dipilih.',
            'product_id.exists' => 'Produk tidak valid.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal 1.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::findOrFail($request->product_id);

        // Authorize stock update
        $this->authorize('updateStock', $product);

        // Tambah stok produk
        $product->increment('stok_saat_ini', $request->jumlah);

        // Catat ke history
        History::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'tipe_transaksi' => 'masuk',
            'jumlah' => $request->jumlah,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('transactions.barang-masuk')
            ->with('success', 'Transaksi barang masuk berhasil dicatat.');
    }

    /**
     * Show form barang keluar
     */
    public function createBarangKeluar()
    {
        $products = Product::orderBy('kode_barang')->get();
        return view('transactions.barang-keluar', compact('products'));
    }

    /**
     * Store barang keluar
     */
    public function storeBarangKeluar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'jumlah' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ], [
            'product_id.required' => 'Produk wajib dipilih.',
            'product_id.exists' => 'Produk tidak valid.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal 1.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::findOrFail($request->product_id);

        // Authorize stock update
        $this->authorize('updateStock', $product);

        // Validasi stok cukup
        if ($request->jumlah > $product->stok_saat_ini) {
            return redirect()->back()
                ->withErrors(['jumlah' => 'Jumlah keluar tidak boleh lebih besar dari stok saat ini ('.$product->stok_saat_ini.').'])
                ->withInput();
        }

        // Kurangi stok produk
        $product->decrement('stok_saat_ini', $request->jumlah);

        // Catat ke history
        History::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'tipe_transaksi' => 'keluar',
            'jumlah' => $request->jumlah,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('transactions.barang-keluar')
            ->with('success', 'Transaksi barang keluar berhasil dicatat.');
    }
} 