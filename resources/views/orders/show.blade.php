@extends('layouts.app')

@section('title', 'Заказ #' . $order->id . ' - ТехЦиф')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Order Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">Заказ #{{ $order->id }}</h1>
                    <p class="text-muted mb-0">Оформлен {{ $order->created_at->format('d.m.Y в H:i') }}</p>
                </div>
                <span class="badge bg-{{ $order->status_badge }} fs-5">{{ $order->status_text }}</span>
            </div>
            
            <div class="row">
                <!-- Order Details -->
                <div class="col-lg-8">
                    <!-- Order Items -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Товары в заказе</h5>
                        </div>
                        <div class="card-body">
                            @foreach($order->items as $item)
                                <div class="row align-items-center py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
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
                                    <div class="col-md-5 col-9">
                                        <h6 class="mb-1">
                                            <a href="{{ route('product.show', $item->product) }}" class="text-decoration-none">
                                                {{ $item->product->name }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">{{ $item->product->category->name ?? 'Без категории' }}</small>
                                    </div>
                                    <div class="col-md-2 col-4 text-center">
                                        <span class="fw-bold">{{ $item->quantity }} шт.</span>
                                    </div>
                                    <div class="col-md-2 col-4 text-center">
                                        <span class="text-muted">{{ number_format($item->price, 0, '.', ' ') }} ₽</span>
                                    </div>
                                    <div class="col-md-1 col-4 text-center">
                                        <strong>{{ number_format($item->quantity * $item->price, 0, '.', ' ') }} ₽</strong>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Delivery Information -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Информация о доставке</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Получатель</h6>
                                    <p class="mb-1">{{ $order->full_name }}</p>
                                    <p class="mb-1">{{ $order->phone }}</p>
                                    <p class="mb-0">{{ $order->email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Доставка</h6>
                                    <p class="mb-1">
                                        <strong>{{ $order->delivery_method == 'courier' ? 'Курьерская доставка' : 'Самовывоз' }}</strong>
                                    </p>
                                    <p class="mb-0">{{ $order->address }}</p>
                                </div>
                            </div>
                            
                            @if($order->notes)
                                <hr>
                                <h6>Комментарий к заказу</h6>
                                <p class="mb-0">{{ $order->notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Сумма заказа</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Товары ({{ $order->items->sum('quantity') }} шт.):</span>
                                <span>{{ number_format($order->total, 0, '.', ' ') }} ₽</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Доставка:</span>
                                <span class="text-success">Бесплатно</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong class="fs-5">Итого:</strong>
                                <strong class="fs-5 text-primary">{{ number_format($order->total, 0, '.', ' ') }} ₽</strong>
                            </div>
                            
                            <div class="mb-3">
                                <h6>Способ оплаты</h6>
                                <p class="mb-0">{{ $order->payment_method == 'card' ? 'Банковская карта' : 'Наличными при получении' }}</p>
                            </div>
                            
                            @if($order->status === 'pending')
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Ваш заказ принят и ожидает обработки. Мы свяжемся с вами в ближайшее время.
                                </div>
                            @elseif($order->status === 'processing')
                                <div class="alert alert-warning">
                                    <i class="fas fa-clock me-2"></i>
                                    Ваш заказ обрабатывается. Ожидайте уведомления об отправке.
                                </div>
                            @elseif($order->status === 'shipped')
                                <div class="alert alert-primary">
                                    <i class="fas fa-truck me-2"></i>
                                    Ваш заказ отправлен и находится в пути.
                                </div>
                            @elseif($order->status === 'delivered')
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Заказ успешно доставлен. Спасибо за покупку!
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('orders') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left me-1"></i> Все заказы
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
