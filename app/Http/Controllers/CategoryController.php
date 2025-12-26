<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{

    public function index()
    {
        try {
            $categories = Category::orderBy('created_at', 'desc')->get();
            return view('categories.index', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Failed to retrieve categories: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }


    public function create()
    {
        try {
            return view('categories.create');
        } catch (\Exception $e) {
            Log::error('Failed to load create form: ' . $e->getMessage(), [
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
                'status' => ['required', 'in:active,inactive'],
            ]);

            Category::create($validated);

            return redirect()->route('categories.index')
                ->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create category: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function edit(Category $category)
    {
        try {
            return view('categories.edit', compact('category'));
        } catch (\Exception $e) {
            Log::error('Failed to load edit form: ' . $e->getMessage(), [
                'exception' => $e,
                'category_id' => $category->id ?? null,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function update(Request $request, Category $category)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'status' => ['required', 'in:active,inactive'],
            ]);

            $category->update($validated);

            return redirect()->route('categories.index')
                ->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update category: ' . $e->getMessage(), [
                'exception' => $e,
                'category_id' => $category->id ?? null,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();

            return redirect()->route('categories.index')
                ->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete category: ' . $e->getMessage(), [
                'exception' => $e,
                'category_id' => $category->id ?? null,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
