@extends('layouts.master')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">All Products</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
    </div>
    
    @if($products->count() > 0)
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="product-thumb">
                                @else
                                    <span class="no-image">No Image</span>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>
                                <span class="status-badge status-badge-{{ $product->status }}">
                                    {{ $product->status }}
                                </span>
                            </td>
                            <td>{{ $product->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-form" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">👕</div>
            <p class="empty-state-text">No products found. Create your first product to get started.</p>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
        </div>
    @endif
</div>
@endsection

