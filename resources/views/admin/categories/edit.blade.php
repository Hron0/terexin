@extends('admin.layouts.app')

@section('title', 'Редактирование категории')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Редактирование категории</h1>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Назад к списку
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Название категории <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Изображение категории</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                <small class="form-text text-muted">Рекомендуемый размер: 600x400 пикселей. Максимальный размер: 2MB.</small>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                <div id="imagePreview" class="mt-2">
                    @if($category->image)
                        <div class="mb-2">
                            <p>Текущее изображение:</p>
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="preview-image">
                        </div>
                    @endif
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
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
    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
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
            @if($category->image)
                preview.innerHTML = `
                    <div class="mb-2">
                        <p>Текущее изображение:</p>
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="preview-image">
                    </div>
                `;
            @endif
        }
    });
</script>
@endsection