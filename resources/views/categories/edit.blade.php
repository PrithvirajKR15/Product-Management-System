@extends('layouts.master')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Edit Category</h2>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to Categories</a>
    </div>
    
    <div class="form-container">
        <form method="POST" action="{{ route('categories.update', $category) }}" class="login-form">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name" class="form-label">Category Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-input @error('name') input-error @enderror" 
                    value="{{ old('name', $category->name) }}" 
                    required 
                    autofocus
                    placeholder="e.g., Men, Women, Summer Wear"
                >
                @error('name')
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
                    <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Update Category</button>
            </div>
        </form>
    </div>
</div>
@endsection

