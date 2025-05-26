@extends('admin.layouts.app')

@section('title', 'Управление заказами')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-shopping-bag me-2"></i>Управление заказами
        </h1>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Всего заказов</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_orders'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Ожидают</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_orders'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">В обработке</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['processing_orders'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cogs fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Завершено</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['completed_orders'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Выручка</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_revenue'], 0, '.', ' ') }} ₽</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-ruble-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Сегодня</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['today_orders'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Фильтры</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Поиск</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="ID заказа, имя, email...">
                </div>
                
                <div class="col-md-2">
                    <label for="status" class="form-label">Статус</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Все статусы</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Ожидает обработки</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>В обработке</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Отправлен</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Доставлен</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Отменен</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="date_from" class="form-label">Дата от</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>
                
                <div class="col-md-2">
                    <label for="date_to" class="form-label">Дата до</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>
                
                <div class="col-md-2">
                    <label for="sort" class="form-label">Сортировка</label>
                    <select class="form-select" id="sort" name="sort">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Сначала новые</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Сначала старые</option>
                        <option value="total_desc" {{ request('sort') == 'total_desc' ? 'selected' : '' }}>Сумма: по убыванию</option>
                        <option value="total_asc" {{ request('sort') == 'total_asc' ? 'selected' : '' }}>Сумма: по возрастанию</option>
                    </select>
                </div>
                
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Заказы ({{ $orders->total() }})
            </h6>
            <div>
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bulkUpdateModal">
                    <i class="fas fa-edit me-1"></i>Массовое обновление
                </button>
            </div>
        </div>
        <div class="card-body">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="ordersTable">
                        <thead>
                            <tr>
                                <th width="50">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>ID</th>
                                <th>Клиент</th>
                                <th>Товары</th>
                                <th>Сумма</th>
                                <th>Статус</th>
                                <th>Дата</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="order-checkbox" value="{{ $order->id }}">
                                    </td>
                                    <td>
                                        <strong>#{{ $order->id }}</strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $order->full_name }}</strong>
                                            @if($order->user)
                                                <br><small class="text-muted">{{ $order->user->email }}</small>
                                            @endif
                                            <br><small class="text-muted">{{ $order->phone }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $order->items->sum('quantity') }} шт.
                                            @if($order->items->count() > 0)
                                                <br>{{ Str::limit($order->items->first()->product->name ?? 'Товар удален', 30) }}
                                                @if($order->items->count() > 1)
                                                    <br><em>и еще {{ $order->items->count() - 1 }} товар(ов)</em>
                                                @endif
                                            @endif
                                        </small>
                                    </td>
                                    <td>
                                        <strong>{{ number_format($order->total, 0, '.', ' ') }} ₽</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $order->status_badge }}">
                                            {{ $order->status_text }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $order->created_at->format('d.m.Y') }}
                                            <br>{{ $order->created_at->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.orders.show', $order) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Просмотр">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($order->status === 'pending')
                                                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="processing">
                                                    <button type="submit" class="btn btn-sm btn-success" title="Подтвердить">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Заказы не найдены</h5>
                    <p class="text-muted">Попробуйте изменить параметры фильтрации</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Bulk Update Modal -->
<div class="modal fade" id="bulkUpdateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Массовое обновление статуса</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.orders.bulk-update') }}" id="bulkUpdateForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bulk_status" class="form-label">Новый статус</label>
                        <select class="form-select" id="bulk_status" name="status" required>
                            <option value="">Выберите статус</option>
                            <option value="pending">Ожидает обработки</option>
                            <option value="processing">В обработке</option>
                            <option value="shipped">Отправлен</option>
                            <option value="delivered">Доставлен</option>
                            <option value="cancelled">Отменен</option>
                        </select>
                    </div>
                    <div id="selectedOrdersInfo"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Обновить статус</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all checkbox functionality
        const selectAllCheckbox = document.getElementById('selectAll');
        const orderCheckboxes = document.querySelectorAll('.order-checkbox');
        
        selectAllCheckbox.addEventListener('change', function() {
            orderCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkUpdateButton();
        });
        
        orderCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectAllCheckbox();
                updateBulkUpdateButton();
            });
        });
        
        function updateSelectAllCheckbox() {
            const checkedCount = document.querySelectorAll('.order-checkbox:checked').length;
            selectAllCheckbox.checked = checkedCount === orderCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < orderCheckboxes.length;
        }
        
        function updateBulkUpdateButton() {
            const checkedCount = document.querySelectorAll('.order-checkbox:checked').length;
            const bulkUpdateBtn = document.querySelector('[data-bs-target="#bulkUpdateModal"]');
            bulkUpdateBtn.disabled = checkedCount === 0;
        }
        
        // Bulk update modal
        const bulkUpdateModal = document.getElementById('bulkUpdateModal');
        bulkUpdateModal.addEventListener('show.bs.modal', function() {
            const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
            const orderIds = Array.from(checkedBoxes).map(cb => cb.value);
            
            // Add hidden inputs for selected order IDs
            const form = document.getElementById('bulkUpdateForm');
            const existingInputs = form.querySelectorAll('input[name="order_ids[]"]');
            existingInputs.forEach(input => input.remove());
            
            orderIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'order_ids[]';
                input.value = id;
                form.appendChild(input);
            });
            
            // Update info text
            const infoDiv = document.getElementById('selectedOrdersInfo');
            infoDiv.innerHTML = `<div class="alert alert-info">Выбрано заказов: <strong>${orderIds.length}</strong></div>`;
        });
        
        // Auto-submit forms with confirmation
        document.querySelectorAll('form[action*="update-status"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Вы уверены, что хотите изменить статус этого заказа?')) {
                    e.preventDefault();
                }
            });
        });
        
        // Initialize bulk update button state
        updateBulkUpdateButton();
    });
</script>
@endsection
