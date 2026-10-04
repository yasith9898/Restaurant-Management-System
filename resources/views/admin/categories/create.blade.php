@extends('layouts.app')

@section('title', 'Add New Category')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Add New Category</h4>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i> Back to Categories
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Category Name (English) *</label>
                    <input type="text" class="form-control" name="name_en" value="{{ old('name_en') }}" required>
                    @error('name_en')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Category Name (Arabic)</label>
                    <input type="text" class="form-control" name="name_ar" value="{{ old('name_ar') }}">
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-4">
                    <label class="form-label">Category Name (Kurdish)</label>
                    <input type="text" class="form-control" name="name_ku" value="{{ old('name_ku') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Category Name (Turkish)</label>
                    <input type="text" class="form-control" name="name_tr" value="{{ old('name_tr') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Category Name (Persian)</label>
                    <input type="text" class="form-control" name="name_fa" value="{{ old('name_fa') }}">
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label class="form-label">Order</label>
                    <input type="number" class="form-control" name="order" value="{{ old('order', 0) }}" min="0">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Category Image</label>
                    <input type="file" class="form-control" name="image" accept="image/*">
                    <div class="form-text">Supported formats: JPEG, PNG, JPG, GIF (Max: 2MB)</div>
                </div>
            </div>

            <div class="mt-4">
                <label class="form-label d-block mb-2">Status</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active"
                        {{ old('is_active', true) ? 'checked' : '' }}
                        style="width: 3em; height: 1.5em; background-color: #9859C5;">
                    <label class="form-check-label">Active Category</label>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-chip">
                    <i class="bi bi-plus-circle me-2"></i> Create Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
