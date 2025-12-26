@extends('layouts.master')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="card">
    <h2 class="card-title">Welcome to Admin Panel</h2>
    <p>Welcome, <strong>{{ Auth::guard('admins')->user()->name }}</strong>!</p>
    <p>Email: <strong>{{ Auth::guard('admins')->user()->email }}</strong></p>
</div>

<div class="card">
    <h2 class="card-title">Quick Actions</h2>
    <div class="btn-group">
        <a href="{{ route('categories.index') }}" class="btn btn-primary">Manage Categories</a>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Add New Category</a>
    </div>
</div>
@endsection

