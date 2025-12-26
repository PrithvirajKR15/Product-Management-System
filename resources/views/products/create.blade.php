@extends('layouts.master')

@section('title', 'Create Product')
@section('page-title', 'Create Product')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Add New Product</h2>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
    </div>
    
    <div class="form-container">
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="login-form" id="productForm">
            @csrf
            
            <div class="form-group">
                <label for="name" class="form-label">Product Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-input @error('name') input-error @enderror" 
                    value="{{ old('name') }}" 
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
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                >{{ old('description') }}</textarea>
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
                    value="{{ old('price') }}" 
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
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    class="form-input @error('image') input-error @enderror" 
                    accept="image/*"
                    required
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
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Create Product</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/admin.js') }}"></script>
@endsection

