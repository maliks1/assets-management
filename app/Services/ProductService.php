<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getPaginated($search = null)
    {
        $query = Product::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('kode_barang')->paginate(10);
    }

    public function store(array $data)
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data)
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product)
    {
        if ($product->history()->count() > 0) {
            throw new \Exception('Produk memiliki riwayat transaksi.');
        }

        $product->delete();
    }
}