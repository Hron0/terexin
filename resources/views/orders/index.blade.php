@extends('layouts.app')

@section('title', 'Мои заказы - ТехЦиф')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">
        <i class="fas fa-shopping-bag me-2"></i>Мои заказы
    </h1>
    
    @if($orders->count() > 0)
        <div class="row">
            @foreach($orders as $order)
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Заказ #{{ $order->id }}</h5>
                                <small class="text-muted">{{ $order->created_at->format('d.m.Y H:i') }}</small>
                            </div>
                            <span class="badge bg-{{ $order->status_badge }} fs-6">{{ $order->status_text }}</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <strong>Получатель:</strong><br>
                                            {{ $order->full_name }}<br>
                                            <small class="text-muted">{{ $order->phone }}</small>
                                        </div>
                                        <div class="col-sm-6">
                                            <strong>Доставка:</strong><br>
                                            {{ $order->delivery_method == 'courier' ? 'Курьерская доставка' : 'Самовывоз' }}<br>
                                            <small class="text-muted">{{ Str::limit($order->address, 50) }}</small>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-6">
                                            <strong>Оплата:</strong><br>
                                            {{ $order->payment_method == 'card' ? 'Банковская карта' : 'Наличными при получении' }}
                                        </div>
                                        <div class="col-sm-6">
                                            <strong>Товаров:</strong><br>
                                            {{ $order->items->sum('quantity') }} шт.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <div class="mb-3">
                                        <h4 class="text-primary mb-0">{{ number_format($order->total, 0, '.', ' ') }} ₽</h4>
                                    </div>
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">
                                        <i class="fas fa-eye me-1"></i> Подробнее
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-bag fa-5x text-muted mb-4"></i>
            <h3 class="text-muted mb-3">У вас пока нет заказов</h3>
            <p class="text-muted mb-4">Оформите первый заказ в нашем каталоге</p>
            <a href="{{ route('catalog') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-cart me-2"></i>Перейти к покупкам
            </a>
        </div>
    @endif
</div>
@endsection
