@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Edit Category</h4>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i> Back to Categories
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Category Name (English) *</label>
                    <input type="text" class="form-control" name="name_en" value="{{ old('name_en', $category->name_en) }}" required>
                    @error('name_en')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Category Name (Arabic)</label>
                    <input type="text" class="form-control" name="name_ar" value="{{ old('name_ar', $category->name_ar) }}">
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-4">
                    <label class="form-label">Category Name (Kurdish)</label>
                    <input type="text" class="form-control" name="name_ku" value="{{ old('name_ku', $category->name_ku) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Category Name (Turkish)</label>
                    <input type="text" class="form-control" name="name_tr" value="{{ old('name_tr', $category->name_tr) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Category Name (Persian)</label>
                    <input type="text" class="form-control" name="name_fa" value="{{ old('name_fa', $category->name_fa) }}">
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label class="form-label">Order</label>
                    <input type="number" class="form-control" name="order" value="{{ old('order', $category->order) }}" min="0">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Category Image</label>
                    <input type="file" class="form-control" name="image" accept="image/*">
                    <div class="form-text">Supported formats: JPEG, PNG, JPG, GIF (Max: 2MB)</div>

                    @if($category->image)
                    <div class="mt-2">
                        <label class="form-label">Current Image:</label>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset('storage/' . $category->image) }}"
                                 alt="{{ $category->name_en }}"
                                 class="img-thumbnail"
                                 style="width: 80px; height: 60px; object-fit: cover;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="removeImage">
                                <label class="form-check-label small" for="removeImage">
                                    Remove current image
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="mt-4">
                <label class="form-label d-block mb-2">Status</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                        {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                        style="width: 3em; height: 1.5em; background-color: #9859C5;">
                    <label class="form-check-label">Active Category</label>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-chip">
                    <i class="bi bi-check-circle me-2"></i> Update Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
