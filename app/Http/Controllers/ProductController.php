<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::with('category')->orderBy('created_at', 'desc')->get();
            return view('products.index', compact('products'));
        } catch (\Exception $e) {
            Log::error('Failed to retrieve products: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function create()
    {
        try {
            $categories = Category::where('status', 'active')->orderBy('name')->get();
            return view('products.create', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Failed to load create product form: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'category_id' => ['required', 'exists:categories,id'],
                'description' => ['required', 'string'],
                'price' => ['required', 'numeric', 'min:0'],
                'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                'status' => ['required', 'in:active,inactive'],
                'attribute_key' => ['sometimes', 'array'],
                'attribute_key.*' => ['required_with:attribute_value.*', 'string', 'max:255'],
                'attribute_value' => ['sometimes', 'array'],
                'attribute_value.*' => ['required_with:attribute_key.*', 'string'],
            ]);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
                $validated['image'] = $imagePath;
            }

            $product = Product::create($validated);

            if ($request->has('attribute_key') && $request->has('attribute_value')) {
                $attributeKeys = $request->input('attribute_key', []);
                $attributeValues = $request->input('attribute_value', []);

                foreach ($attributeKeys as $index => $key) {
                    if (!empty($key) && isset($attributeValues[$index]) && !empty($attributeValues[$index])) {
                        ProductAttribute::create([
                            'product_id' => $product->id,
                            'attribute_key' => $key,
                            'attribute_value' => $attributeValues[$index],
                        ]);
                    }
                }
            }
            return redirect()->route('products.index')
                ->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create product: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->except(['password', '_token']),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function edit(Product $product)
    {
        try {
            $categories = Category::where('status', 'active')->orderBy('name')->get();
            $product->load('productAttributes');
            return view('products.edit', compact('product', 'categories'));
        } catch (\Exception $e) {
            Log::error('Failed to load edit product form: ' . $e->getMessage(), [
                'exception' => $e,
                'product_id' => $product->id ?? null,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'category_id' => ['required', 'exists:categories,id'],
                'description' => ['required', 'string'],
                'price' => ['required', 'numeric', 'min:0'],
                'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                'status' => ['required', 'in:active,inactive'],
                'attribute_key' => ['sometimes', 'array'],
                'attribute_key.*' => ['required_with:attribute_value.*', 'string', 'max:255'],
                'attribute_value' => ['sometimes', 'array'],
                'attribute_value.*' => ['required_with:attribute_key.*', 'string'],
            ]);

            if ($request->hasFile('image')) {
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
                $imagePath = $request->file('image')->store('products', 'public');
                $validated['image'] = $imagePath;
            } else {
                unset($validated['image']);
            }

            $product->update($validated);
            $product->productAttributes()->delete();

            if ($request->has('attribute_key') && $request->has('attribute_value')) {
                $attributeKeys = $request->input('attribute_key', []);
                $attributeValues = $request->input('attribute_value', []);

                foreach ($attributeKeys as $index => $key) {
                    if (!empty($key) && isset($attributeValues[$index]) && !empty($attributeValues[$index])) {
                        ProductAttribute::create([
                            'product_id' => $product->id,
                            'attribute_key' => $key,
                            'attribute_value' => $attributeValues[$index],
                        ]);
                    }
                }
            }
            return redirect()->route('products.index')
                ->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update product: ' . $e->getMessage(), [
                'exception' => $e,
                'product_id' => $product->id ?? null,
                'request_data' => $request->except(['password', '_token']),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function destroy(Product $product)
    {
        try {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->delete();
            return redirect()->route('products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete product: ' . $e->getMessage(), [
                'exception' => $e,
                'product_id' => $product->id ?? null,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
