@extends('layouts.app')

@section('title', $product->name . ' - ТехЦиф')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catalog') }}">Каталог</a></li>
            @if($product->category)
                <li class="breadcrumb-item"><a href="{{ route('catalog') }}?category_id={{ $product->category->id }}">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-md-5 mb-4">
            <div class="card">
                <div class="card-body">
                    <div id="productCarousel" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-inner">
                            @if($product->main_image)
                                <div class="carousel-item active">
                                    <img src="{{ asset('storage/' . $product->main_image) }}" class="d-block w-100" alt="{{ $product->name }}" style="height: 400px; object-fit: contain;">
                                </div>
                            @endif
                            
                            @foreach($product->images as $image)
                                <div class="carousel-item">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" class="d-block w-100" alt="{{ $product->name }}" style="height: 400px; object-fit: contain;">
                                </div>
                            @endforeach
                            
                            @if(!$product->main_image && $product->images->count() == 0)
                                <div class="carousel-item active">
                                    <img src="https://via.placeholder.com/400x400?text=Нет+фото" class="d-block w-100" alt="Нет фото">
                                </div>
                            @endif
                        </div>
                        
                        @if($product->main_image || $product->images->count() > 0)
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Предыдущий</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Следующий</span>
                            </button>
                        @endif
                    </div>
                    
                    @if(($product->main_image ? 1 : 0) + $product->images->count() > 1)
                        <div class="row mt-3">
                            @if($product->main_image)
                                <div class="col-3 mb-3">
                                    <img src="{{ asset('storage/' . $product->main_image) }}" class="img-thumbnail thumbnail-img active" data-bs-target="#productCarousel" data-bs-slide-to="0" alt="{{ $product->name }}">
                                </div>
                            @endif
                            
                            @foreach($product->images as $key => $image)
                                <div class="col-3 mb-3">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail thumbnail-img" data-bs-target="#productCarousel" data-bs-slide-to="{{ ($product->main_image ? 1 : 0) + $key }}" alt="{{ $product->name }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="col-md-7">
            <h1 class="mb-3">{{ $product->name }}</h1>
            
            <div class="d-flex align-items-center mb-3">
                <div class="me-3">
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="far fa-star text-warning"></i>
                    <span class="ms-1">(4.0)</span>
                </div>
                <div class="text-muted">Отзывов: 12</div>
            </div>
            
            <div class="mb-4">
                <h3 class="text-primary">{{ number_format($product->price, 0, '.', ' ') }} ₽</h3>
                <p class="text-success"><i class="fas fa-check-circle me-1"></i> В наличии</p>
            </div>
            
            <div class="mb-4">
                <p>{{ $product->description }}</p>
            </div>
            
            @auth
                <form id="addToCartForm" class="mb-4">
                    @csrf
                    <div class="d-flex align-items-center">
                        <div class="input-group me-3" style="width: 130px;">
                            <button class="btn btn-outline-secondary" type="button" id="decreaseQuantity">-</button>
                            <input type="number" class="form-control text-center" id="quantity" name="quantity" value="1" min="1">
                            <button class="btn btn-outline-secondary" type="button" id="increaseQuantity">+</button>
                        </div>
                        
                        <button type="submit" class="btn btn-primary flex-grow-1" id="addToCartBtn">
                            <i class="fas fa-shopping-cart me-2"></i> Добавить в корзину
                        </button>
                        
                        <button type="button" class="btn btn-outline-danger ms-2" id="addToFavoritesBtn">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </form>
            @else
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>
                    <a href="{{ route('login') }}" class="alert-link">Войдите в аккаунт</a>, чтобы добавить товар в корзину
                </div>
            @endauth
            
            @if($product->characteristics)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Характеристики</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped mb-0">
                            <tbody>
                                @if($product->characteristics->screen)
                                    <tr>
                                        <th>Экран</th>
                                        <td>{{ $product->characteristics->screen }}</td>
                                    </tr>
                                @endif
                                
                                @if($product->characteristics->processor)
                                    <tr>
                                        <th>Процессор</th>
                                        <td>{{ $product->characteristics->processor }}</td>
                                    </tr>
                                @endif
                                
                                @if($product->characteristics->ram)
                                    <tr>
                                        <th>Оперативная память</th>
                                        <td>{{ $product->characteristics->ram }}</td>
                                    </tr>
                                @endif
                                
                                @if($product->characteristics->battery)
                                    <tr>
                                        <th>Аккумулятор</th>
                                        <td>{{ $product->characteristics->battery }}</td>
                                    </tr>
                                @endif
                                
                                @if($product->characteristics->os)
                                    <tr>
                                        <th>Операционная система</th>
                                        <td>{{ $product->characteristics->os }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            
            <div class="d-flex align-items-center">
                <span class="me-3">Поделиться:</span>
                <div class="social-share">
                    <a href="#" class="me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="me-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="me-2"><i class="fab fa-telegram"></i></a>
                    <a href="#" class="me-2"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-5">
            <h3 class="mb-4">Похожие товары</h3>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="col">
                        <div class="card h-100 product-card">
                            <div class="position-relative">
                                @if($relatedProduct->main_image)
                                    <img src="{{ asset('storage/' . $relatedProduct->main_image) }}" class="card-img-top" alt="{{ $relatedProduct->name }}" style="height: 200px; object-fit: contain;">
                                @else
                                    <img src="https://via.placeholder.com/300x200?text=Нет+фото" class="card-img-top" alt="Нет фото">
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <p class="text-muted small mb-1">{{ $relatedProduct->category->name ?? 'Без категории' }}</p>
                                <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-bold fs-5">{{ number_format($relatedProduct->price, 0, '.', ' ') }} ₽</span>
                                        @auth
                                            <button class="btn btn-sm btn-outline-primary add-to-cart-quick" data-product-id="{{ $relatedProduct->id }}">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                        @endauth
                                    </div>
                                    <a href="{{ route('product.show', $relatedProduct) }}" class="btn btn-primary w-100">Подробнее</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .thumbnail-img {
        cursor: pointer;
        height: 70px;
        object-fit: contain;
        opacity: 0.6;
        transition: opacity 0.3s;
    }
    .thumbnail-img:hover, .thumbnail-img.active {
        opacity: 1;
    }
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .social-share a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #f8f9fa;
        color: #6c757d;
        transition: all 0.3s;
    }
    .social-share a:hover {
        background-color: #0d6efd;
        color: white;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity buttons
        const quantityInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decreaseQuantity');
        const increaseBtn = document.getElementById('increaseQuantity');
        
        if (decreaseBtn) {
            decreaseBtn.addEventListener('click', function() {
                const currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });
        }
        
        if (increaseBtn) {
            increaseBtn.addEventListener('click', function() {
                const currentValue = parseInt(quantityInput.value);
                quantityInput.value = currentValue + 1;
            });
        }
        
        // Add to cart form
        const addToCartForm = document.getElementById('addToCartForm');
        if (addToCartForm) {
            addToCartForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const quantity = parseInt(quantityInput.value);
                const productId = {{ $product->id }};
                
                fetch(`/basket/add/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ quantity: quantity })
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
        }
        
        // Quick add to cart for related products
        document.querySelectorAll('.add-to-cart-quick').forEach(button => {
            button.addEventListener('click', function() {
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
        
        // Add to favorites button
        const addToFavoritesBtn = document.getElementById('addToFavoritesBtn');
        if (addToFavoritesBtn) {
            addToFavoritesBtn.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (icon.classList.contains('far')) {
                    icon.classList.replace('far', 'fas');
                    showAlert('success', 'Товар добавлен в избранное!');
                } else {
                    icon.classList.replace('fas', 'far');
                    showAlert('info', 'Товар удален из избранного!');
                }
            });
        }
        
        // Thumbnail images
        const thumbnails = document.querySelectorAll('.thumbnail-img');
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                thumbnails.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                const slideIndex = this.getAttribute('data-bs-slide-to');
                const carousel = new bootstrap.Carousel(document.getElementById('productCarousel'));
                carousel.to(parseInt(slideIndex));
            });
        });
        
        // Initialize first thumbnail as active
        if (thumbnails.length > 0) {
            thumbnails[0].classList.add('active');
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
