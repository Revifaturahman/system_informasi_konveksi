<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProductCategory::latest()->get();
        return view('product.product-category', compact('categories'));
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
            'id' => 'nullable|exists:product_categories,id',
            'category_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        if ($request->id) {
            // UPDATE data kategori
            $category = ProductCategory::findOrFail($request->id);
            $category->update($validated);
            $message = 'Kategori berhasil diperbarui!';
        } else {
            // CREATE kategori baru
            ProductCategory::create($validated);
            $message = 'Kategori baru berhasil ditambahkan!';
        }

        return redirect()->route('product-category.index')->with('success', $message);
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
    public function destroy(ProductCategory $productCategory)
    {
        // dd($productCategory);
        $productCategory->delete();
        return redirect()->route('product-category.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
