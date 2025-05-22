@extends('admin.layouts.app')

@section('title', 'Панель управления')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Панель управления</h1>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 card-dashboard">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Товары</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['products'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2 card-dashboard">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Категории</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['categories'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-folder fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2 card-dashboard">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Пользователи</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['users'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2 card-dashboard">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Заказы</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['orders'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Products -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Последние добавленные товары</h6>
        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary">
            Все товары
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Изображение</th>
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Цена</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats['recent_products'] as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if($product->main_image)
                                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="preview-image">
                                @else
                                    <img src="https://via.placeholder.com/100x100?text=Нет+фото" alt="Нет фото" class="preview-image">
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? 'Без категории' }}</td>
                            <td>{{ number_format($product->price, 0, '.', ' ') }} ₽</td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Товары не найдены</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Быстрые действия</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-block w-100">
                            <i class="fas fa-plus me-1"></i> Добавить товар
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-block w-100">
                            <i class="fas fa-plus me-1"></i> Добавить категорию
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-info btn-block w-100">
                            <i class="fas fa-cog me-1"></i> Настройки сайта
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-warning btn-block w-100">
                            <i class="fas fa-list me-1"></i> Управление заказами
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Информация о системе</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h5>ТехЦиф - Админ-панель</h5>
                    <p>Версия: 1.0.0</p>
                </div>
                <div class="mb-3">
                    <h6>Сервер:</h6>
                    <p>PHP: {{ phpversion() }}<br>
                    Laravel: {{ app()->version() }}</p>
                </div>
                <div>
                    <h6>Последнее обновление:</h6>
                    <p>{{ date('d.m.Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection