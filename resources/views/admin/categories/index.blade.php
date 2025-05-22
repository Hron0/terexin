@extends('admin.layouts.app')

@section('title', 'Управление категориями')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Управление категориями</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">
        <i class="fas fa-plus me-1"></i> Добавить категорию
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Изображение</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Кол-во товаров</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="preview-image">
                                @else
                                    <img src="https://via.placeholder.com/100x100?text=Нет+фото" alt="Нет фото" class="preview-image">
                                @endif
                            </td>
                            <td>{{ $category->name }}</td>
                            <td>{{ Str::limit($category->description, 100) }}</td>
                            <td>{{ $category->products->count() }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Вы уверены, что хотите удалить эту категорию?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Категории не найдены</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $categories->links() }}
    </div>
</div>
@endsection