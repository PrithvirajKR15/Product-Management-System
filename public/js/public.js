(function($) {
    'use strict';

    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    const $searchInput = $('#search');
    const $categoryCheckboxes = $('.category-filter');
    const $minPriceInput = $('#min_price');
    const $maxPriceInput = $('#max_price');
    const $clearFiltersBtn = $('#clearFilters');

    const $productsGrid = $('#productsGrid');
    const $productCount = $('#productCount');
    const $paginationContainer = $('#paginationContainer');
    const $loadingIndicator = $('#loadingIndicator');
    const $noProducts = $('#noProducts');
    

    let currentPage = 1;
    
    let searchTimeout;
    const debounceDelay = 500;
    
    function getFilterData(page = 1) {
        const categories = $categoryCheckboxes
            .filter(':checked')
            .map(function() {
                return $(this).val();
            })
            .get();
        
        return {
            search: $searchInput.val().trim(),
            categories: categories,
            min_price: $minPriceInput.val() || null,
            max_price: $maxPriceInput.val() || null,
            page: page
        };
    }
    
    function toggleLoading(show) {
        if (show) {
            $loadingIndicator.removeClass('hidden');
            $productsGrid.css('opacity', '0.5');
        } else {
            $loadingIndicator.addClass('hidden');
            $productsGrid.css('opacity', '1');
        }
    }
    
    function applyFilters(page = 1) {
        const filterData = getFilterData(page);
        currentPage = page;
        
        toggleLoading(true);
        $noProducts.addClass('hidden');
        
        $.ajax({
            url: '/products/filter',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            contentType: 'application/json',
            data: JSON.stringify(filterData),
            success: function(data) {
                $productsGrid.html(data.html);
                if (data.pagination) {
                    $paginationContainer.html(data.pagination);
                    attachPaginationListeners();
                } else {
                    $paginationContainer.html('');
                }
                $productCount.text(data.count + ' products found');
                
                if (data.count === 0) {
                    $noProducts.removeClass('hidden');
                } else {
                    $noProducts.addClass('hidden');
                }
                
                $('html, body').animate({
                    scrollTop: $productsGrid.offset().top - 100
                }, 500);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                $productCount.text('Error loading products');
            },
            complete: function() {
                toggleLoading(false);
            }
        });
    }
    
    function attachPaginationListeners() {
        $paginationContainer.find('.pagination-link:not(.pagination-link-disabled):not(.pagination-link-active)')
            .off('click')
            .on('click', function(e) {
                e.preventDefault();
                const page = $(this).attr('data-page') || $(this).text().trim();
                applyFilters(parseInt(page));
            });
    }
    
    if ($searchInput.length) {
        $searchInput.on('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(applyFilters, debounceDelay);
        });
    }
    
    if ($categoryCheckboxes.length > 0) {
        $categoryCheckboxes.on('change', applyFilters);
    }
    
    if ($minPriceInput.length) {
        $minPriceInput.on('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(applyFilters, debounceDelay);
        });
    }
    
    if ($maxPriceInput.length) {
        $maxPriceInput.on('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(applyFilters, debounceDelay);
        });
    }
    
    if ($clearFiltersBtn.length) {
        $clearFiltersBtn.on('click', function() {
            if ($searchInput.length) {
                $searchInput.val('');
            }
            
            $categoryCheckboxes.prop('checked', false);
            
            if ($minPriceInput.length) {
                $minPriceInput.val('');
            }
            if ($maxPriceInput.length) {
                $maxPriceInput.val('');
            }
            currentPage = 1;
            applyFilters(1);
        });
    }
    
    $(document).ready(function() {
        attachPaginationListeners();
    });
})(jQuery);