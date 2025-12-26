@extends('layouts.master')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Edit Product</h2>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
    </div>
    
    <div class="form-container">
        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data" class="login-form" id="productForm">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name" class="form-label">Product Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-input @error('name') input-error @enderror" 
                    value="{{ old('name', $product->name) }}" 
                    required 
                    autofocus
                    placeholder="Enter product name"
                >
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id" class="form-label">Category</label>
                <select 
                    id="category_id" 
                    name="category_id" 
                    class="form-select @error('category_id') input-error @enderror" 
                    required
                >
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea 
                    id="description" 
                    name="description" 
                    class="form-input @error('description') input-error @enderror" 
                    rows="5"
                    required
                    placeholder="Enter product description"
                >{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="price" class="form-label">Price</label>
                <input 
                    type="number" 
                    id="price" 
                    name="price" 
                    class="form-input @error('price') input-error @enderror" 
                    value="{{ old('price', $product->price) }}" 
                    step="0.01"
                    min="0"
                    required
                    placeholder="0.00"
                >
                @error('price')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="image" class="form-label">Product Image</label>
                @if($product->image)
                    <div class="current-image">
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="product-preview">
                        <p class="image-note">Current image. Upload a new image to replace it.</p>
                    </div>
                @endif
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    class="form-input @error('image') input-error @enderror" 
                    accept="image/*"
                >
                @error('image')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <select 
                    id="status" 
                    name="status" 
                    class="form-select @error('status') input-error @enderror" 
                    required
                >
                    <option value="">Select Status</option>
                    <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Product Attributes Section -->
            <div class="form-group">
                <div class="attributes-header">
                    <label class="form-label">Product Attributes</label>
                    <button type="button" onclick="addAttributeRow()" class="btn btn-secondary btn-sm">Add More</button>
                </div>
                <div id="attributesContainer">
                    @if($product->productAttributes && $product->productAttributes->count() > 0)
                        @foreach($product->productAttributes as $attribute)
                            <div class="attribute-row">
                                <div class="attribute-input-group">
                                    <input 
                                        type="text" 
                                        name="attribute_key[]" 
                                        class="form-input attribute-key" 
                                        value="{{ $attribute->attribute_key }}"
                                        placeholder="Key (e.g., Size, Color)"
                                    >
                                    <input 
                                        type="text" 
                                        name="attribute_value[]" 
                                        class="form-input attribute-value" 
                                        value="{{ $attribute->attribute_value }}"
                                        placeholder="Value (e.g., Large, Red)"
                                    >
                                    <button type="button" onclick="removeAttributeRow(this)" class="btn btn-danger btn-sm remove-attribute">Remove</button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="attribute-row">
                            <div class="attribute-input-group">
                                <input 
                                    type="text" 
                                    name="attribute_key[]" 
                                    class="form-input attribute-key" 
                                    placeholder="Key (e.g., Size, Color)"
                                >
                                <input 
                                    type="text" 
                                    name="attribute_value[]" 
                                    class="form-input attribute-value" 
                                    placeholder="Value (e.g., Large, Red)"
                                >
                                <button type="button" onclick="removeAttributeRow(this)" class="btn btn-danger btn-sm remove-attribute remove-attribute-hidden">Remove</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Update Product</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/admin.js') }}"></script>
@endsection

