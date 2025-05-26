@extends('admin.layouts.app')

@section('title', 'Заказ #' . $order->id)

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-shopping-bag me-2"></i>Заказ #{{ $order->id }}
            </h1>
            <p class="text-muted mb-0">Оформлен {{ $order->created_at->format('d.m.Y в H:i') }}</p>
        </div>
        <div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Назад к списку
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Order Details -->
        <div class="col-lg-8">
            <!-- Order Items -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Товары в заказе</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Товар</th>
                                    <th width="100">Количество</th>
                                    <th width="120">Цена</th>
                                    <th width="120">Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product && $item->product->main_image)
                                                    <img src="{{ asset('storage/' . $item->product->main_image) }}" 
                                                         alt="{{ $item->product->name }}" 
                                                         class="me-3 rounded" 
                                                         style="width: 50px; height: 50px; object-fit: contain;">
                                                @else
                                                    <div class="me-3 bg-light rounded d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    @if($item->product)
                                                        <h6 class="mb-1">{{ $item->product->name }}</h6>
                                                        <small class="text-muted">{{ $item->product->category->name ?? 'Без категории' }}</small>
                                                    @else
                                                        <h6 class="mb-1 text-muted">Товар удален</h6>
                                                        <small class="text-muted">ID: {{ $item->product_id }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $item->quantity }} шт.</span>
                                        </td>
                                        <td class="text-end">
                                            {{ number_format($item->price, 0, '.', ' ') }} ₽
                                        </td>
                                        <td class="text-end">
                                            <strong>{{ number_format($item->quantity * $item->price, 0, '.', ' ') }} ₽</strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-active">
                                    <th colspan="3" class="text-end">Итого:</th>
                                    <th class="text-end">{{ number_format($order->total, 0, '.', ' ') }} ₽</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Customer & Delivery Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Информация о доставке</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Получатель</h6>
                            <p class="mb-1"><strong>{{ $order->full_name }}</strong></p>
                            <p class="mb-1">
                                <i class="fas fa-phone me-1"></i>{{ $order->phone }}
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-envelope me-1"></i>{{ $order->email }}
                            </p>
                            @if($order->user)
                                <p class="mb-0">
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>Зарегистрированный пользователь: {{ $order->user->name }}
                                    </small>
                                </p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6>Доставка</h6>
                            <p class="mb-1">
                                <strong>
                                    @if($order->delivery_method === 'courier')
                                        <i class="fas fa-truck me-1"></i>Курьерская доставка
                                    @else
                                        <i class="fas fa-store me-1"></i>Самовывоз
                                    @endif
                                </strong>
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-map-marker-alt me-1"></i>{{ $order->address }}
                            </p>
                            <p class="mb-0">
                                <strong>Оплата:</strong>
                                @if($order->payment_method === 'card')
                                    <i class="fas fa-credit-card me-1"></i>Банковская карта
                                @else
                                    <i class="fas fa-money-bill me-1"></i>Наличными при получении
                                @endif
                            </p>
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

        <!-- Order Status & Actions -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Статус заказа</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <span class="badge bg-{{ $order->status_badge }} fs-6 px-3 py-2">
                            {{ $order->status_text }}
                        </span>
                    </div>
                    
                    <!-- Status Update Form -->
                    <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Изменить статус</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Ожидает обработки</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>В обработке</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Отправлен</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Доставлен</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Отменен</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Комментарий (необязательно)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" 
                                      placeholder="Добавить комментарий к изменению статуса...">{{ $order->notes }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-1"></i>Обновить статус
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Сводка заказа</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Товаров:</span>
                        <span>{{ $order->items->sum('quantity') }} шт.</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Сумма товаров:</span>
                        <span>{{ number_format($order->total, 0, '.', ' ') }} ₽</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Доставка:</span>
                        <span class="text-success">Бесплатно</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Итого:</strong>
                        <strong class="text-primary">{{ number_format($order->total, 0, '.', ' ') }} ₽</strong>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Быстрые действия</h6>
                </div>
                <div class="card-body">
                    @if($order->status === 'pending')
                        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="mb-2">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="processing">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check me-1"></i>Подтвердить заказ
                            </button>
                        </form>
                    @endif
                    
                    @if($order->status === 'processing')
                        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="mb-2">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="shipped">
                            <button type="submit" class="btn btn-info w-100">
                                <i class="fas fa-shipping-fast me-1"></i>Отправить заказ
                            </button>
                        </form>
                    @endif
                    
                    @if($order->status === 'shipped')
                        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="mb-2">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="delivered">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check-circle me-1"></i>Отметить доставленным
                            </button>
                        </form>
                    @endif
                    
                    @if(!in_array($order->status, ['delivered', 'cancelled']))
                        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="btn btn-danger w-100" 
                                    onclick="return confirm('Вы уверены, что хотите отменить этот заказ?')">
                                <i class="fas fa-times me-1"></i>Отменить заказ
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
