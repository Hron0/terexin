@extends('layouts.app')

@section('title', 'Каталог товаров - ТехЦиф')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Каталог товаров</h1>
    
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Фильтры</h5>
                </div>
                <div class="card-body">
                    <form id="filter-form" method="GET" action="{{ route('catalog') }}">
                        <!-- Preserve search term -->
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        
                        <!-- Category Filter -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Категории</h6>
                            <div class="list-group">
                                <a href="#" 
                                   class="list-group-item list-group-item-action category-filter {{ !request('category_id') ? 'active' : '' }}" 
                                   data-category-id="">
                                    Все категории
                                </a>
                                @foreach($categories as $category)
                                <a href="#" 
                                   class="list-group-item list-group-item-action category-filter {{ request('category_id') == $category->id ? 'active' : '' }}" 
                                   data-category-id="{{ $category->id }}">
                                    {{ $category->name }}
                                </a>
                                @endforeach
                            </div>
                            <input type="hidden" name="category_id" id="category_id" value="{{ request('category_id') }}">
                        </div>
                        
                        <!-- Price Filter -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Цена</h6>
                            <div class="row">
                                <div class="col-6">
                                    <label for="min_price" class="form-label">От</label>
                                    <input type="number" class="form-control" id="min_price" name="min_price" 
                                           value="{{ request('min_price', $minPrice) }}" min="{{ $minPrice }}" max="{{ $maxPrice }}">
                                </div>
                                <div class="col-6">
                                    <label for="max_price" class="form-label">До</label>
                                    <input type="number" class="form-control" id="max_price" name="max_price" 
                                           value="{{ request('max_price', $maxPrice) }}" min="{{ $minPrice }}" max="{{ $maxPrice }}">
                                </div>
                            </div>
                            <div class="mt-3">
                                <div id="price-slider"></div>
                            </div>
                        </div>
                        
                        <!-- Sort Filter -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Сортировка</h6>
                            <select class="form-select" id="sort" name="sort">
                                <option value="newest" {{ $sortBy == 'newest' ? 'selected' : '' }}>Сначала новые</option>
                                <option value="price_asc" {{ $sortBy == 'price_asc' ? 'selected' : '' }}>Цена: по возрастанию</option>
                                <option value="price_desc" {{ $sortBy == 'price_desc' ? 'selected' : '' }}>Цена: по убыванию</option>
                                <option value="name_asc" {{ $sortBy == 'name_asc' ? 'selected' : '' }}>Название: А-Я</option>
                                <option value="name_desc" {{ $sortBy == 'name_desc' ? 'selected' : '' }}>Название: Я-А</option>
                            </select>
                        </div>
                        
                        <!-- Loading indicator -->
                        <div id="loading-indicator" class="text-center d-none">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Загрузка...</span>
                            </div>
                            <small class="d-block mt-2 text-muted">Применяем фильтры...</small>
                        </div>
                        
                        <a href="{{ route('catalog') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times me-1"></i>Сбросить фильтры
                        </a>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="col-lg-9">
            <!-- Products Count and View Toggle -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <p class="mb-0">
                        Найдено товаров: <strong>{{ $products->total() }}</strong>
                        @if(request('search'))
                            <br><small class="text-muted">по запросу: "{{ request('search') }}"</small>
                        @endif
                        @if(request('category_id'))
                            @php
                                $selectedCategory = $categories->find(request('category_id'));
                            @endphp
                            @if($selectedCategory)
                                <br><small class="text-muted">в категории: {{ $selectedCategory->name }}</small>
                            @endif
                        @endif
                    </p>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-secondary view-btn active" data-view="grid">
                        <i class="fas fa-th"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary view-btn" data-view="list">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>
            
            @if($products->count() > 0)
                <!-- Grid View (default) -->
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="products-grid">
                    @foreach($products as $product)
                    <div class="col">
                        <div class="card h-100 product-card">
                            <div class="position-relative">
                                @if($product->main_image)
                                    <img src="{{ asset('storage/' . $product->main_image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: contain;">
                                @else
                                    <img src="https://via.placeholder.com/300x200?text=Нет+фото" class="card-img-top" alt="Нет фото">
                                @endif
                                <div class="position-absolute top-0 end-0 p-2">
                                    <button class="btn btn-sm btn-outline-danger rounded-circle favorite-btn">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <p class="text-muted small mb-1">{{ $product->category->name ?? 'Без категории' }}</p>
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-bold fs-5">{{ number_format($product->price, 0, '.', ' ') }} ₽</span>
                                        @auth
                                            <button class="btn btn-sm btn-primary add-to-cart-btn" data-product-id="{{ $product->id }}" title="Добавить в корзину">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                        @endauth
                                    </div>
                                    <a href="{{ route('product.show', $product) }}" class="btn btn-primary w-100">Подробнее</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- List View (hidden by default) -->
                <div class="d-none" id="products-list">
                    @foreach($products as $product)
                    <div class="card mb-3 product-card-list">
                        <div class="row g-0">
                            <div class="col-md-3">
                                @if($product->main_image)
                                    <img src="{{ asset('storage/' . $product->main_image) }}" class="img-fluid rounded-start" alt="{{ $product->name }}" style="height: 200px; object-fit: contain;">
                                @else
                                    <img src="https://via.placeholder.com/300x200?text=Нет+фото" class="img-fluid rounded-start" alt="Нет фото">
                                @endif
                            </div>
                            <div class="col-md-9">
                                <div class="card-body h-100 d-flex flex-column">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="text-muted small mb-1">{{ $product->category->name ?? 'Без категории' }}</p>
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                        </div>
                                        <button class="btn btn-sm btn-outline-danger rounded-circle favorite-btn">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    </div>
                                    
                                    <p class="card-text">{{ Str::limit($product->description, 150) }}</p>
                                    
                                    @if($product->characteristics)
                                    <div class="small text-muted mb-3">
                                        <div class="row">
                                            @if($product->characteristics->screen)
                                            <div class="col-md-6">
                                                <i class="fas fa-mobile-alt me-1"></i> Экран: {{ $product->characteristics->screen }}
                                            </div>
                                            @endif
                                            
                                            @if($product->characteristics->processor)
                                            <div class="col-md-6">
                                                <i class="fas fa-microchip me-1"></i> Процессор: {{ $product->characteristics->processor }}
                                            </div>
                                            @endif
                                            
                                            @if($product->characteristics->ram)
                                            <div class="col-md-6">
                                                <i class="fas fa-memory me-1"></i> Память: {{ $product->characteristics->ram }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold fs-5">{{ number_format($product->price, 0, '.', ' ') }} ₽</span>
                                            <div>
                                                @auth
                                                    <button class="btn btn-primary me-2 add-to-cart-btn" data-product-id="{{ $product->id }}">
                                                        <i class="fas fa-shopping-cart me-1"></i> В корзину
                                                    </button>
                                                @endauth
                                                <a href="{{ route('product.show', $product) }}" class="btn btn-primary">Подробнее</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> По вашему запросу товары не найдены. Попробуйте изменить параметры фильтрации.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.css">
<style>
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .favorite-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
    .favorite-btn.active i {
        color: #dc3545;
        font-weight: 900;
    }
    .add-to-cart-btn {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: all 0.3s ease;
    }
    .add-to-cart-btn:hover {
        transform: scale(1.1);
    }
    .product-card-list .add-to-cart-btn {
        width: auto;
        height: auto;
        padding: 0.375rem 0.75rem;
    }
    .noUi-connect {
        background: #0d6efd;
    }
    .category-filter {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .category-filter.active {
        background-color: #0d6efd !important;
        color: white !important;
        border-color: #0d6efd !important;
    }
    .category-filter:hover:not(.active) {
        background-color: #f8f9fa;
    }
    .filter-updating {
        opacity: 0.7;
        pointer-events: none;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let filterTimeout;
        const filterForm = document.getElementById('filter-form');
        const loadingIndicator = document.getElementById('loading-indicator');
        const categoryIdInput = document.getElementById('category_id');
        
        // Show loading indicator
        function showLoading() {
            loadingIndicator.classList.remove('d-none');
            document.querySelector('.col-lg-9').classList.add('filter-updating');
        }
        
        // Hide loading indicator
        function hideLoading() {
            loadingIndicator.classList.add('d-none');
            document.querySelector('.col-lg-9').classList.remove('filter-updating');
        }
        
        // Submit form with delay
        function submitFormWithDelay() {
            clearTimeout(filterTimeout);
            showLoading();
            
            filterTimeout = setTimeout(() => {
                filterForm.submit();
            }, 1500);
        }
        
        // Initialize price slider
        const priceSlider = document.getElementById('price-slider');
        const minPriceInput = document.getElementById('min_price');
        const maxPriceInput = document.getElementById('max_price');
        
        if (priceSlider) {
            noUiSlider.create(priceSlider, {
                start: [
                    parseInt(minPriceInput.value) || {{ $minPrice }},
                    parseInt(maxPriceInput.value) || {{ $maxPrice }}
                ],
                connect: true,
                step: 1000,
                range: {
                    'min': {{ $minPrice }},
                    'max': {{ $maxPrice }}
                },
                format: {
                    to: function(value) {
                        return Math.round(value);
                    },
                    from: function(value) {
                        return Math.round(value);
                    }
                }
            });
            
            // Update inputs when slider changes
            priceSlider.noUiSlider.on('update', function(values, handle) {
                const value = values[handle];
                if (handle === 0) {
                    minPriceInput.value = value;
                } else {
                    maxPriceInput.value = value;
                }
            });
            
            // Submit form when slider changes (with delay)
            priceSlider.noUiSlider.on('change', function() {
                submitFormWithDelay();
            });
            
            // Update slider when inputs change
            minPriceInput.addEventListener('change', function() {
                priceSlider.noUiSlider.set([this.value, null]);
                submitFormWithDelay();
            });
            
            maxPriceInput.addEventListener('change', function() {
                priceSlider.noUiSlider.set([null, this.value]);
                submitFormWithDelay();
            });
        }
        
        // Toggle view (grid/list)
        const viewButtons = document.querySelectorAll('.view-btn');
        const productsGrid = document.getElementById('products-grid');
        const productsList = document.getElementById('products-list');
        
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                viewButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                const view = this.getAttribute('data-view');
                if (view === 'grid') {
                    productsGrid.classList.remove('d-none');
                    productsList.classList.add('d-none');
                } else {
                    productsGrid.classList.add('d-none');
                    productsList.classList.remove('d-none');
                }
            });
        });
        
        // Category filter
        const categoryFilters = document.querySelectorAll('.category-filter');
        
        categoryFilters.forEach(filter => {
            filter.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Update active state immediately for visual feedback
                categoryFilters.forEach(f => f.classList.remove('active'));
                this.classList.add('active');
                
                // Get the category ID from data attribute
                const categoryId = this.getAttribute('data-category-id');
                console.log('Selected category ID:', categoryId); // Debug log
                
                // Set the hidden input value
                categoryIdInput.value = categoryId;
                console.log('Hidden input value set to:', categoryIdInput.value); // Debug log
                
                // Submit form with delay
                submitFormWithDelay();
            });
        });
        
        // Sort change handler
        document.getElementById('sort').addEventListener('change', function() {
            submitFormWithDelay();
        });
        
        // Favorite button toggle
        document.querySelectorAll('.favorite-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.classList.toggle('active');
                const icon = this.querySelector('i');
                if (icon.classList.contains('far')) {
                    icon.classList.replace('far', 'fas');
                } else {
                    icon.classList.replace('fas', 'far');
                }
            });
        });
        
        // Add to cart functionality
        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                
                fetch(`/basket/add/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ quantity: 1 })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update cart badge
                        updateCartBadge(data.cart_count);
                        
                        // Show success message
                        showAlert('success', data.message);
                    } else {
                        showAlert('danger', 'Произошла ошибка при добавлении товара в корзину');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('danger', 'Произошла ошибка при добавлении товара в корзину');
                });
            });
        });
        
        // Cancel loading if user navigates away
        window.addEventListener('beforeunload', function() {
            clearTimeout(filterTimeout);
            hideLoading();
        });
    });
    
    function updateCartBadge(count) {
        const badge = document.querySelector('.cart-badge');
        if (badge) {
            if (count > 0) {
                badge.textContent = count;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }
    }
    
    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 3000);
    }
</script>
@endsection
