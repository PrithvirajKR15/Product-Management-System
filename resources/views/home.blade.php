<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Products - Cloth Store</title>
    @if(Storage::disk('public')->exists('images/favicon.png'))
        <link rel="icon" type="image/png" href="{{ Storage::url('images/favicon.png') }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="public-body">
    <div class="public-wrapper">
        <header class="public-header">
            <div class="header-content">
                <div class="header-logo-section">
                    @if(Storage::disk('public')->exists('images/logo.png'))
                    <a href="{{ route('home') }}"><img src="{{ Storage::url('images/logo.png') }}" alt="Logo" class="site-logo"></a>
                    @elseif(Storage::disk('public')->exists('images/logo.jpg'))
                        <a href="{{ route('home') }}"><img src="{{ Storage::url('images/logo.jpg') }}" alt="Logo" class="site-logo"></a>
                    @else
                        <a href="{{ route('home') }}"><img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="site-logo"></a>
                        <a href="{{ route('home') }}"><h1 class="site-title">Cloth Store</h1></a>
                    @endif
                </div>
                <nav class="header-nav">
                    <!-- <a href="{{ route('home') }}" class="nav-link">Home</a> -->
                    <a href="{{ route('admin.login') }}" class="nav-link">Admin Login</a>
                </nav>
            </div>
        </header>

        <div class="public-container">
            <!-- Top Filters Bar -->
            <div class="filters-topbar">
                <h2 class="filters-title">Filters</h2>
                
                <div class="filters-content">
                    <!-- Search Bar -->
                    <div class="filter-section">
                        <label for="search" class="filter-label">Search</label>
                        <input 
                            type="text" 
                            id="search" 
                            name="search" 
                            class="filter-input" 
                            placeholder="Search by name..."
                        >
                    </div>

                    <!-- Category Filter -->
                    <div class="filter-section">
                        <label class="filter-label">Categories</label>
                        <div class="checkbox-group-horizontal">
                            @foreach($categories as $category)
                                <label class="checkbox-item">
                                    <input 
                                        type="checkbox" 
                                        name="categories[]" 
                                        value="{{ $category->id }}" 
                                        class="filter-checkbox category-filter"
                                    >
                                    <span class="checkbox-text">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="filter-section">
                        <label class="filter-label">Price Range</label>
                        <div class="price-range-group-horizontal">
                            <div class="price-input-group">
                                <label for="min_price" class="price-label">Min</label>
                                <input 
                                    type="number" 
                                    id="min_price" 
                                    name="min_price" 
                                    class="filter-input price-input" 
                                    min="0" 
                                    step="0.01"
                                    placeholder="{{ number_format($minPrice, 2) }}"
                                >
                            </div>
                            <div class="price-input-group">
                                <label for="max_price" class="price-label">Max</label>
                                <input 
                                    type="number" 
                                    id="max_price" 
                                    name="max_price" 
                                    class="filter-input price-input" 
                                    min="0" 
                                    step="0.01"
                                    placeholder="{{ number_format($maxPrice, 2) }}"
                                >
                            </div>
                        </div>
                    </div>
                    <!-- Clear Filters Button -->
                    <div class="filter-section filter-section-button">
                        <label class="filter-label filter-label-hidden">Actions</label>
                        <button type="button" id="clearFilters" class="btn btn-secondary">Clear Filters</button>
                    </div>
                </div>
                <div class="filters-content">
                    
                </div>
            </div>

            <!-- Products Section -->
            <main class="products-main">
                <div class="products-header">
                    <h2 class="products-title">Our Products</h2>
                    <p class="products-count" id="productCount">{{ $products->total() }} products found</p>
                </div>

                <div id="productsGrid" class="products-grid">
                    @include('partials.product-grid', ['products' => $products])
                </div>

                <div id="paginationContainer">
                    @include('partials.pagination', ['products' => $products])
                </div>

                <div id="loadingIndicator" class="loading-indicator hidden">
                    <p>Loading products...</p>
                </div>

                <div id="noProducts" class="no-products hidden">
                    <p>No products found matching your filters.</p>
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/public.js') }}"></script>
</body>
</html>

