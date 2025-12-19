<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    /**
     * Check if user is admin
     */
    private function isAdmin(): bool
    {
        return auth()->check() && auth()->user()->email === 'admin@gmail.com';
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access');
        }
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        Product::create($validated);

        return redirect()->route('dashboard')->with(['message' => 'Produk berhasil ditambahkan!', 'type' => 'added']);
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access');
        }
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('dashboard')->with(['message' => 'Produk berhasil diperbarui!', 'type' => 'edited']);
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $product->delete();

        return redirect()->route('dashboard')->with(['message' => 'Produk berhasil dihapus!', 'type' => 'deleted']);
    }
}
