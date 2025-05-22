@extends('admin.layouts.app')

@section('title', 'Редактирование товара')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Редактирование товара</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Назад к списку
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Название товара <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="price" class="form-label">Цена (₽) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" step="0.01" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="category_id" class="form-label">Категория <span class="text-danger">*</span></label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                        <option value="">Выберите категорию</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание <span class="text-danger">*</span></label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="main_image" class="form-label">Основное изображение</label>
                <input type="file" class="form-control @error('main_image') is-invalid @enderror" id="main_image" name="main_image" accept="image/*">
                <small class="form-text text-muted">Рекомендуемый размер: 600x600 пикселей. Максимальный размер: 2MB.</small>
                @error('main_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                <div id="mainImagePreview" class="mt-2">
                    @if($product->main_image)
                        <div class="mb-2">
                            <p>Текущее изображение:</p>
                            <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="preview-image">
                        </div>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label for="additional_images" class="form-label">Добавить дополнительные изображения</label>
                <input type="file" class="form-control @error('additional_images') is-invalid @enderror" id="additional_images" name="additional_images[]" accept="image/*" multiple>
                <small class="form-text text-muted">Вы можете выбрать несколько изображений. Максимальный размер каждого: 2MB.</small>
                @error('additional_images')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="additionalImagesPreview" class="additional-images mt-2"></div>
                
                @if($product->images->count() > 0)
                    <div class="mt-3">
                        <p>Текущие дополнительные изображения:</p>
                        <div class="additional-images">
                            @foreach($product->images as $image)
                                <div class="image-preview-container">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}" class="preview-image">
                                    <div class="delete-btn" data-image-id="{{ $image->id }}">
                                        <i class="fas fa-times"></i>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <h4 class="mt-4 mb-3">Характеристики</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="screen" class="form-label">Экран</label>
                    <input type="text" class="form-control @error('screen') is-invalid @enderror" id="screen" name="screen" value="{{ old('screen', $product->characteristics->screen ?? '') }}">
                    @error('screen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="processor" class="form-label">Процессор</label>
                    <input type="text" class="form-control @error('processor') is-invalid @enderror" id="processor" name="processor" value="{{ old('processor', $product->characteristics->processor ?? '') }}">
                    @error('processor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="ram" class="form-label">Оперативная память</label>
                    <input type="text" class="form-control @error('ram') is-invalid @enderror" id="ram" name="ram" value="{{ old('ram', $product->characteristics->ram ?? '') }}">
                    @error('ram')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="battery" class="form-label">Аккумулятор</label>
                    <input type="text" class="form-control @error('battery') is-invalid @enderror" id="battery" name="battery" value="{{ old('battery', $product->characteristics->battery ?? '') }}">
                    @error('battery')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="os" class="form-label">Операционная система</label>
                    <input type="text" class="form-control @error('os') is-invalid @enderror" id="os" name="os" value="{{ old('os', $product->characteristics->os ?? '') }}">
                    @error('os')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Сохранить изменения
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Main image preview
    document.getElementById('main_image').addEventListener('change', function(e) {
        const preview = document.getElementById('mainImagePreview');
        preview.innerHTML = '';
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('preview-image', 'mt-2');
                preview.appendChild(img);
            }
            
            reader.readAsDataURL(this.files[0]);
        } else {
            // Restore current image preview if no new image selected
            @if($product->main_image)
                preview.innerHTML = `
                    <div class="mb-2">
                        <p>Текущее изображение:</p>
                        <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="preview-image">
                    </div>
                `;
            @endif
        }
    });

    // Additional images preview
    document.getElementById('additional_images').addEventListener('change', function(e) {
        const preview = document.getElementById('additionalImagesPreview');
        preview.innerHTML = '';
        
        if (this.files && this.files.length > 0) {
            for (let i = 0; i < this.files.length; i++) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('preview-image', 'mt-2', 'me-2');
                    preview.appendChild(img);
                }
                
                reader.readAsDataURL(this.files[i]);
            }
        }
    });

    // Delete additional image
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Вы уверены, что хотите удалить это изображение?')) {
                const imageId = this.getAttribute('data-image-id');
                const container = this.parentElement;
                
                fetch(`{{ url('admin/products/images') }}/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        container.remove();
                    } else {
                        alert('Ошибка при удалении изображения');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ошибка при удалении изображения');
                });
            }
        });
    });
</script>
@endsection