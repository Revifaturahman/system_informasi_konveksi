<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        $categories = ProductCategory::all();
        return view('product.product', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:products,id',
            'category_id' => 'required|exists:product_categories,id',
            'product_name' => 'required|string|max:100',
            'stock' => 'required|integer',
        ]);

        if ($request->id) {
            Product::findOrFail($request->id)->update($validated);
            $message = 'Produk berhasil diperbarui!';
        } else {
            Product::create($validated);
            $message = 'Produk baru berhasil ditambahkan!';
        }

        return redirect()->route('product.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Produk berhasil dihapus!');
    }
}
