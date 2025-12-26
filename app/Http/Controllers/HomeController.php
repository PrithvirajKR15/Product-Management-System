<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        try {
            $categories = Category::where('status', 'active')->orderBy('name')->get();
            
            $query = Product::where('status', 'active')->with('category');
            
            if ($request->has('categories') && !empty($request->categories)) {
                $categoryIds = is_array($request->categories) ? $request->categories : [$request->categories];
                $query->whereIn('category_id', $categoryIds);
            }
            
            if ($request->has('min_price') && $request->min_price !== null && $request->min_price !== '') {
                $query->where('price', '>=', $request->min_price);
            }
            
            if ($request->has('max_price') && $request->max_price !== null && $request->max_price !== '') {
                $query->where('price', '<=', $request->max_price);
            }
            
            if ($request->has('search') && !empty($request->search)) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }
            
            $products = $query->orderBy('created_at', 'desc')->paginate(8)->withQueryString();
            
            $minPrice = Product::where('status', 'active')->min('price') ?? 0;
            $maxPrice = Product::where('status', 'active')->max('price') ?? 1000;
            
            return view('home', compact('products', 'categories', 'minPrice', 'maxPrice'));
        } catch (\Exception $e) {
            Log::error('Failed to load home page: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function filter(Request $request)
    {
        try {
            $query = Product::where('status', 'active')->with('category');

            if ($request->has('categories') && !empty($request->categories)) {
                $categoryIds = is_array($request->categories) ? $request->categories : [$request->categories];
                $query->whereIn('category_id', $categoryIds);
            }

            if ($request->has('min_price') && $request->min_price !== null && $request->min_price !== '') {
                $query->where('price', '>=', (float) $request->min_price);
            }
            if ($request->has('max_price') && $request->max_price !== null && $request->max_price !== '') {
                $query->where('price', '<=', (float) $request->max_price);
            }

            if ($request->has('search') && !empty($request->search)) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            $page = (int) ($request->input('page', 1));
            $products = $query->orderBy('created_at', 'desc')->paginate(8, ['*'], 'page', $page);

            return response()->json([
                'html' => view('partials.product-grid', compact('products'))->render(),
                'pagination' => view('partials.pagination', compact('products'))->render(),
                'count' => $products->total()
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to filter products: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
