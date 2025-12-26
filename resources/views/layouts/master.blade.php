<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Product Management System</title>
    @if(Storage::disk('public')->exists('images/favicon.png'))
        <link rel="icon" type="image/png" href="{{ Storage::url('images/favicon.png') }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="admin-body">
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                @if(Storage::disk('public')->exists('images/logo.png'))
                <img src="{{ Storage::url('images/logo.png') }}" alt="Logo" class="sidebar-logo-image">
                @elseif(Storage::disk('public')->exists('images/logo.jpg'))
                <img src="{{ Storage::url('images/logo.jpg') }}" alt="Logo" class="sidebar-logo-image">
                @else
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="sidebar-logo-image">
                <h2 class="sidebar-logo">Cloth Store</h2>
                @endif
                <p class="sidebar-subtitle">Admin Panel</p>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <span class="nav-icon">📊</span>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                            <span class="nav-icon">📁</span>
                            <span class="nav-text">Categories</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                            <span class="nav-icon">👕</span>
                            <span class="nav-text">Products</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <div class="user-info">
                    <p class="user-name">{{ Auth::guard('admins')->user()->name }}</p>
                    <p class="user-email">{{ Auth::guard('admins')->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-block">Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="content-header">
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            </header>
            <div class="content-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        <ul class="error-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>

