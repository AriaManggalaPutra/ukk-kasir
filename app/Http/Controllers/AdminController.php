<?php

namespace App\Http\Controllers;

use App\Models\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin-page.dashboard');
    }

    public function product()
    {
        $products = Product::all();
        return view('admin-page.product', compact('products'));    
    }


    public function createProduct()
    {
        return view('admin-page.create-product');
    }

    public function productStore(Request $request)
    {
        $validated = $request->validate([
            'product_name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('product_image')) {
            $validated['product_image'] = $request->file('product_image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin-product')->with('status', 'Produk berhasil ditambahkan.');
    }

    public function edit(string $id)
    {

        $products = Product::findOrFail($id);
        return view('admin-page.edit', compact('products'));
    }

    public function update(Request $request, $id)
    {

        // dd($request);
        $request->merge([
            'price' => str_replace(['Rp.', '.', ' '], '', $request->price),
        ]);
    
        // Validasi
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $product = Product::findOrFail($id);
    
        if ($request->hasFile('product_image')) {
            $validated['product_image'] = $request->file('product_image')->store('products', 'public');
        }
    
        // Update data produk
        $product->update($validated);
    
        return redirect()->route('admin-product')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin-product')->with('status', 'Produk berhasil dihapus.');
    }

}
