@if(isset($products) && $products->count() > 0)
    @foreach($products as $product)
        <div class="product-card">
            <div class="product-image-container">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="product-image">
                @else
                    <div class="product-image-placeholder">No Image</div>
                @endif
            </div>
            <div class="product-info">
                <h3 class="product-name">{{ $product->name }}</h3>
                <p class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</p>
                <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                <div class="product-footer">
                    <span class="product-price">₹{{ number_format($product->price, 2) }}</span>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="no-products-message">
        <p>No products found.</p>
    </div>
@endif

