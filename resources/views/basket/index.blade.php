@extends('layouts.app')

@section('title', 'Корзина - ТехЦиф')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="fas fa-shopping-cart me-2"></i>Корзина
            </h1>
            
            @if($items->count() > 0)
                <div class="row">
                    <!-- Cart Items -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                @foreach($items as $item)
                                    <div class="row align-items-center border-bottom py-3" data-item-id="{{ $item->id }}">
                                        <div class="col-md-2 col-3">
                                            @if($item->product->main_image)
                                                <img src="{{ asset('storage/' . $item->product->main_image) }}" 
                                                     alt="{{ $item->product->name }}" 
                                                     class="img-fluid rounded" 
                                                     style="max-height: 80px; object-fit: contain;">
                                            @else
                                                <img src="https://via.placeholder.com/80x80?text=Нет+фото" 
                                                     alt="Нет фото" 
                                                     class="img-fluid rounded">
                                            @endif
                                        </div>
                                        
                                        <div class="col-md-4 col-9">
                                            <h6 class="mb-1">
                                                <a href="{{ route('product.show', $item->product) }}" class="text-decoration-none">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h6>
                                            <small class="text-muted">{{ $item->product->category->name ?? 'Без категории' }}</small>
                                        </div>
                                        
                                        <div class="col-md-2 col-6 mt-2 mt-md-0">
                                            <div class="input-group input-group-sm">
                                                <button class="btn btn-outline-secondary quantity-btn" type="button" data-action="decrease">-</button>
                                                <input type="number" class="form-control text-center quantity-input" 
                                                       value="{{ $item->quantity }}" 
                                                       min="1" 
                                                       data-item-id="{{ $item->id }}"
                                                       data-price="{{ $item->product->price }}">
                                                <button class="btn btn-outline-secondary quantity-btn" type="button" data-action="increase">+</button>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2 col-3 mt-2 mt-md-0 text-center">
                                            <strong class="item-total">{{ number_format($item->quantity * $item->product->price, 0, '.', ' ') }} ₽</strong>
                                        </div>
                                        
                                        <div class="col-md-2 col-3 mt-2 mt-md-0 text-center">
                                            <button class="btn btn-sm btn-outline-danger remove-item-btn" data-item-id="{{ $item->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <a href="{{ route('catalog') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-1"></i> Продолжить покупки
                            </a>
                        </div>
                    </div>
                    
                    <!-- Order Summary -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Итого</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Товары ({{ $items->sum('quantity') }} шт.):</span>
                                    <span id="subtotal">{{ number_format($total, 0, '.', ' ') }} ₽</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Доставка:</span>
                                    <span class="text-success">Бесплатно</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Итого:</strong>
                                    <strong id="total">{{ number_format($total, 0, '.', ' ') }} ₽</strong>
                                </div>
                                
                                <a href="{{ route('checkout') }}" class="btn btn-success w-100 mb-2">
                                    <i class="fas fa-credit-card me-1"></i> Оформить заказ
                                </a>
                                
                                <div class="text-center">
                                    <small class="text-muted">
                                        <i class="fas fa-shield-alt me-1"></i>
                                        Безопасная оплата
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Promo Code -->
                        <div class="card shadow-sm mt-3">
                            <div class="card-body">
                                <h6 class="card-title">Промокод</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Введите промокод">
                                    <button class="btn btn-outline-secondary" type="button">Применить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">Ваша корзина пуста</h3>
                    <p class="text-muted mb-4">Добавьте товары в корзину, чтобы оформить заказ</p>
                    <a href="{{ route('catalog') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Перейти к покупкам
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity buttons
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const action = this.getAttribute('data-action');
            const input = this.parentElement.querySelector('.quantity-input');
            const currentValue = parseInt(input.value);
            
            if (action === 'increase') {
                input.value = currentValue + 1;
            } else if (action === 'decrease' && currentValue > 1) {
                input.value = currentValue - 1;
            }
            
            updateQuantity(input);
        });
    });
    
    // Quantity input change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            if (parseInt(this.value) < 1) {
                this.value = 1;
            }
            updateQuantity(this);
        });
    });
    
    // Remove item buttons
    document.querySelectorAll('.remove-item-btn').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            removeItem(itemId);
        });
    });
    
    function updateQuantity(input) {
        const itemId = input.getAttribute('data-item-id');
        const quantity = parseInt(input.value);
        const price = parseFloat(input.getAttribute('data-price'));
        
        // Update item total
        const itemRow = input.closest('[data-item-id]');
        const itemTotal = itemRow.querySelector('.item-total');
        itemTotal.textContent = (quantity * price).toLocaleString('ru-RU') + ' ₽';
        
        // Send AJAX request to update quantity
        fetch(`/basket/update/${itemId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateTotals();
                updateCartBadge(data.cart_count);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
    function removeItem(itemId) {
        if (confirm('Вы уверены, что хотите удалить этот товар из корзины?')) {
            fetch(`/basket/remove/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove item row
                    const itemRow = document.querySelector(`[data-item-id="${itemId}"]`);
                    itemRow.remove();
                    
                    updateTotals();
                    updateCartBadge(data.cart_count);
                    
                    // Check if cart is empty
                    const remainingItems = document.querySelectorAll('[data-item-id]');
                    if (remainingItems.length === 0) {
                        location.reload();
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }
    
    function updateTotals() {
        let subtotal = 0;
        let totalItems = 0;
        
        document.querySelectorAll('[data-item-id]').forEach(row => {
            const quantityInput = row.querySelector('.quantity-input');
            const quantity = parseInt(quantityInput.value);
            const price = parseFloat(quantityInput.getAttribute('data-price'));
            
            subtotal += quantity * price;
            totalItems += quantity;
        });
        
        document.getElementById('subtotal').textContent = subtotal.toLocaleString('ru-RU') + ' ₽';
        document.getElementById('total').textContent = subtotal.toLocaleString('ru-RU') + ' ₽';
        
        // Update items count
        const itemsText = document.querySelector('.card-body .d-flex span');
        if (itemsText) {
            itemsText.textContent = `Товары (${totalItems} шт.):`;
        }
    }
    
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
});
</script>
@endsection
