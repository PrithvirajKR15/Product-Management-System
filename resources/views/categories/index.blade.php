@extends('layouts.master')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">All Categories</h2>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Add New Category</a>
    </div>
    
    @if($categories->count() > 0)
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <span class="status-badge status-badge-{{ $category->status }}">
                                    {{ $category->status }}
                                </span>
                            </td>
                            <td>{{ $category->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-form" onsubmit="return confirm('Are you sure you want to delete this category?');">
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
            <div class="empty-state-icon">📁</div>
            <p class="empty-state-text">No categories found. Create your first category to get started.</p>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Add New Category</a>
        </div>
    @endif
</div>
@endsection

