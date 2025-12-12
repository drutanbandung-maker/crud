<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // tampilan awal daftar produk dan juga data untuk chart
    public function index()
    {
        $products = Product::latest()->get();

        // prepare a lightweight array for charts to avoid Blade parsing issues
        $productsForChart = $products->map(function($p){
            return [
                'name' => $p->name,
                'stock' => $p->stock,
                'price' => $p->price,
                'created_at' => $p->created_at ? $p->created_at->format('Y-m-d') : null,
            ];
        });

        return view('products.index', compact('products','productsForChart'));
    }

// menampilkan form untuk membuat produk baru
    public function create()
    {
        return view('products.create');
    }
// menyimpan data produk baru
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name','stock','price']);
        // ensure image column exists explicitly; set null when no file uploaded
        $data['image'] = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products','public');
            $data['image'] = $path;
        }

        Product::create($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }
// menampilkan detail produk
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }
// menampilkan form untuk mengedit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }
// memperbarui data produk
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $data = $request->only(['name','stock','price']);

        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products','public');
            $data['image'] = $path;
        }

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }
// menghapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // delete image file if present
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
