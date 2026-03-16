<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Transaction;
use Exception;

class ProductController extends Controller
{

    /**  Danh sách sản phẩm */
    public function index()
    {
        $products = Product::where('is_active', true)->get();

        return view('products', [
            'products' => $products,
            'isAdmin' => Auth::check() && Auth::user()->is_admin,
        ]);
    }

    /**  Hiển thị form thêm sản phẩm (Admin Only) */
    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.products.create');
    }

    /**  Lưu sản phẩm mới */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'category'         => 'required|string|max:100',
            'price'            => 'required|numeric|min:2000',
            'description'      => 'nullable|string|max:1000',
            'product_type'     => 'required|in:coinkey,package',
            'coinkey_amount'   => 'required|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validated['product_type'] === 'coinkey') {
            $validated['duration_minutes'] = null;
        }

        $validated['is_active'] = true;

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products')->with('success', '✅ Product added successfully.');
    }

    /**  Hiển thị form chỉnh sửa sản phẩm */
    public function edit(Product $product)
    {
        $this->authorizeAdmin();
        return view('admin.products.edit', compact('product'));
    }

    /**  Cập nhật sản phẩm */
    public function update(Request $request, Product $product)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'category'         => 'required|string|max:100',
            'price'            => 'required|numeric|min:2000',
            'description'      => 'nullable|string|max:1000',
            'product_type'     => 'required|in:coinkey,package',
            'coinkey_amount'   => 'required|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'is_active'        => 'boolean',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validated['product_type'] === 'coinkey') {
            $validated['duration_minutes'] = null;
        }

        // Remove old image if requested
        if ($request->input('remove_image') == '1' && $product->image) {
            Storage::disk('public')->delete($product->image);
            $validated['image'] = null;
        }

        // Replace with new image if uploaded
        if ($request->hasFile('image')) {
            // Delete old image first
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products')->with('success', '✅ Product updated successfully.');
    }

    /**  Xóa sản phẩm */
    public function destroy(Product $product)
    {
        $this->authorizeAdmin();

        // Delete image from disk when product is deleted
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products')->with('success', '🗑️ Product deleted successfully.');
    }


    /**  Chỉ Admin được phép */
    private function authorizeAdmin()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Access denied.');
        }
    }
}
