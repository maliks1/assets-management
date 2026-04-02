<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getPaginated($search = null, $category = null)
    {
        $query = Product::query();

        if ($search) {
            $query->where(function ($queryBuilder) use ($search) {
                $queryBuilder->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%");
            });
        }

        if ($category && $category !== 'semua') {
            $query->where('category_type', $category);
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
            throw new \Exception('Barang memiliki riwayat transaksi.');
        }

        $product->delete();
    }
}