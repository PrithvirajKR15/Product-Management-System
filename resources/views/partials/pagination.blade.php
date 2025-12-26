@if($products->hasPages())
    <div class="pagination-container">
        <div class="pagination">
            {{-- Previous Page Link --}}
            @if($products->onFirstPage())
                <span class="pagination-link pagination-link-disabled">Previous</span>
            @else
                <a href="{{ $products->previousPageUrl() }}" class="pagination-link pagination-link-prev" data-page="{{ $products->currentPage() - 1 }}">Previous</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                @if($page == $products->currentPage())
                    <span class="pagination-link pagination-link-active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="pagination-link" data-page="{{ $page }}">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" class="pagination-link pagination-link-next" data-page="{{ $products->currentPage() + 1 }}">Next</a>
            @else
                <span class="pagination-link pagination-link-disabled">Next</span>
            @endif
        </div>
        
        <div class="pagination-info">
            <p>Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} products</p>
        </div>
    </div>
@endif

