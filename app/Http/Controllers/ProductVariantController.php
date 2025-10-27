<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $variants = ProductVariant::with('product')->latest()->get();
        $products = Product::all();
        return view('product.product-variant', compact('variants', 'products'));
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
            'id' => 'nullable|exists:product_variants,id',
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string|max:10',
            'stock' => 'required|integer|min:0',
        ]);

        if ($request->id) {
            $variant = ProductVariant::findOrFail($request->id);
            $variant->update($validated);
            $message = 'Varian produk berhasil diperbarui!';
        } else {
            ProductVariant::create($validated);
            $message = 'Varian produk baru berhasil ditambahkan!';
        }

        return redirect()->route('product-variant.index')->with('success', $message);
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
    public function destroy(ProductVariant $product_variant)
    {
        $product_variant->delete();
        return redirect()->route('product-variant.index')->with('success', 'Varian produk berhasil dihapus!');
    }
}
