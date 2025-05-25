@extends('layouts.app')

@section('title', 'Оформление заказа - ТехЦиф')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="mb-4">
                <i class="fas fa-shopping-bag me-2"></i>Оформление заказа
            </h1>
            
            <div class="row">
                <!-- Order Form -->
                <div class="col-lg-7">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Информация о заказе</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('orders.create') }}" method="POST" id="checkoutForm">
                                @csrf
                                
                                <!-- Personal Information -->
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-3">
                                        <i class="fas fa-user me-2"></i>Личная информация
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="full_name" class="form-label">Полное имя *</label>
                                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                                   id="full_name" name="full_name" value="{{ old('full_name', Auth::user()->name) }}" required>
                                            @error('full_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email *</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Телефон *</label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone') }}" 
                                               placeholder="+7 (999) 123-45-67" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Delivery Information -->
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-3">
                                        <i class="fas fa-truck me-2"></i>Доставка
                                    </h6>
                                    <div class="mb-3">
                                        <label for="delivery_method" class="form-label">Способ доставки *</label>
                                        <select class="form-select @error('delivery_method') is-invalid @enderror" 
                                                id="delivery_method" name="delivery_method" required>
                                            <option value="">Выберите способ доставки</option>
                                            <option value="courier" {{ old('delivery_method') == 'courier' ? 'selected' : '' }}>
                                                Курьерская доставка (бесплатно)
                                            </option>
                                            <option value="pickup" {{ old('delivery_method') == 'pickup' ? 'selected' : '' }}>
                                                Самовывоз (бесплатно)
                                            </option>
                                        </select>
                                        @error('delivery_method')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Адрес доставки *</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                                  id="address" name="address" rows="3" 
                                                  placeholder="Укажите полный адрес доставки" required>{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Payment Information -->
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-3">
                                        <i class="fas fa-credit-card me-2"></i>Оплата
                                    </h6>
                                    <div class="mb-3">
                                        <label for="payment_method" class="form-label">Способ оплаты *</label>
                                        <select class="form-select @error('payment_method') is-invalid @enderror" 
                                                id="payment_method" name="payment_method" required>
                                            <option value="">Выберите способ оплаты</option>
                                            <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>
                                                Банковская карта онлайн
                                            </option>
                                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>
                                                Наличными при получении
                                            </option>
                                        </select>
                                        @error('payment_method')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Additional Notes -->
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-3">
                                        <i class="fas fa-comment me-2"></i>Дополнительная информация
                                    </h6>
                                    <div class="mb-3">
                                        <label for="notes" class="form-label">Комментарий к заказу</label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                  id="notes" name="notes" rows="3" 
                                                  placeholder="Укажите дополнительные пожелания или комментарии">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-check me-2"></i>Подтвердить заказ
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="col-lg-5">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Ваш заказ</h5>
                        </div>
                        <div class="card-body">
                            <!-- Order Items -->
                            <div class="mb-3">
                                @foreach($items as $item)
                                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                        <div class="me-3">
                                            @if($item->product->main_image)
                                                <img src="{{ asset('storage/' . $item->product->main_image) }}" 
                                                     alt="{{ $item->product->name }}" 
                                                     class="rounded" 
                                                     style="width: 60px; height: 60px; object-fit: contain;">
                                            @else
                                                <img src="https://via.placeholder.com/60x60?text=Нет+фото" 
                                                     alt="Нет фото" 
                                                     class="rounded">
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $item->product->name }}</h6>
                                            <small class="text-muted">{{ $item->product->category->name ?? 'Без категории' }}</small>
                                            <div class="d-flex justify-content-between align-items-center mt-1">
                                                <span class="text-muted">{{ $item->quantity }} шт.</span>
                                                <strong>{{ number_format($item->quantity * $item->product->price, 0, '.', ' ') }} ₽</strong>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Order Totals -->
                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Товары ({{ $items->sum('quantity') }} шт.):</span>
                                    <span>{{ number_format($total, 0, '.', ' ') }} ₽</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Доставка:</span>
                                    <span class="text-success">Бесплатно</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong class="fs-5">Итого:</strong>
                                    <strong class="fs-5 text-primary">{{ number_format($total, 0, '.', ' ') }} ₽</strong>
                                </div>
                            </div>
                            
                            <!-- Security Info -->
                            <div class="text-center">
                                <small class="text-muted">
                                    <i class="fas fa-shield-alt me-1"></i>
                                    Безопасная оплата и защита данных
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Back to Cart -->
                    <div class="mt-3">
                        <a href="{{ route('basket') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left me-1"></i> Вернуться в корзину
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Phone number formatting
        const phoneInput = document.getElementById('phone');
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (value.length <= 1) {
                    value = '+7 (' + value;
                } else if (value.length <= 4) {
                    value = '+7 (' + value.substring(1);
                } else if (value.length <= 7) {
                    value = '+7 (' + value.substring(1, 4) + ') ' + value.substring(4);
                } else if (value.length <= 9) {
                    value = '+7 (' + value.substring(1, 4) + ') ' + value.substring(4, 7) + '-' + value.substring(7);
                } else {
                    value = '+7 (' + value.substring(1, 4) + ') ' + value.substring(4, 7) + '-' + value.substring(7, 9) + '-' + value.substring(9, 11);
                }
            }
            e.target.value = value;
        });
        
        // Form validation
        const form = document.getElementById('checkoutForm');
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Пожалуйста, заполните все обязательные поля');
            }
        });
        
        // Update address placeholder based on delivery method
        const deliveryMethod = document.getElementById('delivery_method');
        const addressField = document.getElementById('address');
        
        deliveryMethod.addEventListener('change', function() {
            if (this.value === 'pickup') {
                addressField.placeholder = 'Укажите удобный пункт самовывоза или оставьте пустым для выбора основного офиса';
            } else {
                addressField.placeholder = 'Укажите полный адрес доставки';
            }
        });
    });
</script>
@endsection
