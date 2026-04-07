<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $service) {}

    public function index(Request $request)
    {
        $category = $request->query('category', 'semua');
        $products = $this->service->getPaginated($request->search, $category);
        return view('products.index', compact('products', 'category'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(ProductRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        $product->load('history.user');

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->service->update($product, $request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        try {
            $this->service->delete($product);
        } catch (\Exception $e) {
            return redirect()->route('products.index')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('products.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}

