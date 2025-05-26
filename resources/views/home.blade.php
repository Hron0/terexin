@extends('layouts.app')

@section('title', 'ТехЦиф - Магазин цифровой техники')

@section('content')
<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">ТехЦиф</h1>
                <p class="lead mb-4">Ваш надежный партнер в мире цифровых технологий. Широкий ассортимент качественной техники по доступным ценам.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('catalog') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Перейти в каталог
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-info-circle me-2"></i>О компании
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('staticImages/homepage2.png') }}" 
                     alt="Цифровая техника" 
                     class="img-fluid rounded shadow-lg"
                     style="max-height: 400px; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center justify-center" style="justify-content: center;">
            <div class="col-md-3 mb-4">
                <div class="feature-item">
                    <div class="feature-icon bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-shipping-fast fa-2x"></i>
                    </div>
                    <h5>Быстрая доставка</h5>
                    <p class="text-muted">Доставка по всей России в кратчайшие сроки</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-item">
                    <div class="feature-icon bg-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-shield-alt fa-2x"></i>
                    </div>
                    <h5>Гарантия качества</h5>
                    <p class="text-muted">Официальная гарантия на всю продукцию</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-item">
                    <div class="feature-icon bg-warning text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-percent fa-2x"></i>
                    </div>
                    <h5>Выгодные цены</h5>
                    <p class="text-muted">Конкурентные цены и регулярные акции</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Category slider section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Категории товаров</h2>
        
        @if($categories->count() > 0)
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($categories as $category)
                    <div class="col">
                        <a href="{{ route('catalog', ['category_id' => $category->id]) }}" class="text-decoration-none">
                            <div class="card h-100 text-center category-card shadow-sm">
                                <div class="card-img-wrapper" style="height: 200px; overflow: hidden;">
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" 
                                             class="card-img-top w-100 h-100" 
                                             alt="{{ $category->name }}" 
                                             style="object-fit: cover; transition: transform 0.3s;">
                                    @else
                                        <img src="https://via.placeholder.com/300x200?text={{ urlencode($category->name) }}" 
                                             class="card-img-top w-100 h-100" 
                                             alt="{{ $category->name }}"
                                             style="object-fit: cover; transition: transform 0.3s;">
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-primary">{{ $category->name }}</h5>
                                    @if($category->description)
                                        <p class="card-text text-muted small">{{ Str::limit($category->description, 100) }}</p>
                                    @endif
                                    <div class="mt-3">
                                        <span class="btn btn-outline-primary">
                                            <i class="fas fa-arrow-right me-1"></i>Смотреть товары
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-5x text-muted mb-4"></i>
                <h3 class="text-muted">Нет категорий</h3>
                <p class="text-muted">Категории товаров скоро появятся</p>
            </div>
        @endif
    </div>
</section>

<!-- Featured Products Section -->
@if($featuredProducts->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Рекомендуемые товары</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($featuredProducts->take(4) as $product)
                <div class="col">
                    <div class="card h-100 product-card shadow-sm">
                        <div class="position-relative">
                            @if($product->main_image)
                                <img src="{{ asset('storage/' . $product->main_image) }}" 
                                     class="card-img-top" 
                                     alt="{{ $product->name }}" 
                                     style="height: 200px; object-fit: contain;">
                            @else
                                <img src="https://via.placeholder.com/300x200?text=Нет+фото" 
                                     class="card-img-top" 
                                     alt="Нет фото"
                                     style="height: 200px; object-fit: contain;">
                            @endif
                            <div class="position-absolute top-0 end-0 p-2">
                                <span class="badge bg-success">Хит</span>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <p class="text-muted small mb-1">{{ $product->category->name ?? 'Без категории' }}</p>
                            <h6 class="card-title">{{ Str::limit($product->name, 50) }}</h6>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-primary">{{ number_format($product->price, 0, '.', ' ') }} ₽</span>
                                    @auth
                                        @if(!Auth::user()->isAdmin())
                                            <button class="btn btn-sm btn-outline-primary add-to-cart-btn" data-product-id="{{ $product->id }}">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                        @endif
                                    @endauth
                                </div>
                                <a href="{{ route('product.show', $product) }}" class="btn btn-primary w-100 btn-sm">Подробнее</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('catalog') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-th-large me-2"></i>Смотреть весь каталог
            </a>
        </div>
    </div>
</section>
@endif

<!-- Newsletter Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h3 class="mb-3">Подпишитесь на новости</h3>
                <p class="mb-0">Получайте информацию о новинках, акциях и специальных предложениях</p>
            </div>
            <div class="col-lg-6">
                <form class="d-flex gap-2 mt-3 mt-lg-0">
                    <input type="email" class="form-control" placeholder="Ваш email адрес" required>
                    <button type="submit" class="btn btn-light">
                        <i class="fas fa-paper-plane me-1"></i>Подписаться
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%);
    }
    
    .category-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
    }
    
    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
    }
    
    .category-card:hover .card-img-top {
        transform: scale(1.05);
    }
    
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .feature-item {
        transition: transform 0.3s;
    }
    
    .feature-item:hover {
        transform: translateY(-5px);
    }
    
    .add-to-cart-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: all 0.3s ease;
    }
    
    .add-to-cart-btn:hover {
        transform: scale(1.1);
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add to cart functionality for featured products
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
        
        // Newsletter subscription
        const newsletterForm = document.querySelector('section.bg-primary form');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const email = this.querySelector('input[type="email"]').value;
                
                // Here you would typically send the email to your backend
                showAlert('success', 'Спасибо за подписку! Мы будем держать вас в курсе новостей.');
                this.reset();
            });
        }
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
