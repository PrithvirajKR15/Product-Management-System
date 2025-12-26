<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductApiController extends Controller
{
    
    public function index()
    {
        try {
            $products = Product::with(['category', 'productAttributes'])->get();
            return ProductResource::collection($products);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'category_id' => ['required', 'exists:categories,id'],
                'description' => ['required', 'string'],
                'price' => ['required', 'numeric', 'min:0'],
                'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                'status' => ['required', 'in:active,inactive'],
                'attributes' => ['sometimes', 'array'],
                'attributes.*.key' => ['required_with:attributes.*.value', 'string', 'max:255'],
                'attributes.*.value' => ['required_with:attributes.*.key', 'string'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $imagePath = $file->storeAs('products', $filename, 'public');
                $data['image'] = $imagePath;
            }

            $attributes = $data['attributes'] ?? [];
            unset($data['attributes']);

            $product = Product::create($data);

            if (!empty($attributes)) {
                foreach ($attributes as $attribute) {
                    if (!empty($attribute['key']) && !empty($attribute['value'])) {
                        ProductAttribute::create([
                            'product_id' => $product->id,
                            'attribute_key' => $attribute['key'],
                            'attribute_value' => $attribute['value'],
                        ]);
                    }
                }
            }

            $product->load(['category', 'productAttributes']);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => new ProductResource($product)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = Product::with(['category', 'productAttributes'])->find($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => new ProductResource($product)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => ['sometimes', 'required', 'string', 'max:255'],
                'category_id' => ['sometimes', 'required', 'exists:categories,id'],
                'description' => ['sometimes', 'required', 'string'],
                'price' => ['sometimes', 'required', 'numeric', 'min:0'],
                'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                'status' => ['sometimes', 'required', 'in:active,inactive'],
                'attributes' => ['sometimes', 'array'],
                'attributes.*.key' => ['required_with:attributes.*.value', 'string', 'max:255'],
                'attributes.*.value' => ['required_with:attributes.*.key', 'string'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            if ($request->hasFile('image')) {
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $imagePath = $file->storeAs('products', $filename, 'public');
                $data['image'] = $imagePath;
            }

            $attributes = $data['attributes'] ?? null;
            if (isset($data['attributes'])) {
                unset($data['attributes']);
            }

            $product->update($data);

            if ($attributes !== null) {

                $product->productAttributes()->delete();

                if (!empty($attributes)) {
                    foreach ($attributes as $attribute) {
                        if (!empty($attribute['key']) && !empty($attribute['value'])) {
                            ProductAttribute::create([
                                'product_id' => $product->id,
                                'attribute_key' => $attribute['key'],
                                'attribute_value' => $attribute['value'],
                            ]);
                        }
                    }
                }
            }

            $product->load(['category', 'productAttributes']);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => new ProductResource($product)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
