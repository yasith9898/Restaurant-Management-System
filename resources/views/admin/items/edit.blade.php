@extends('layouts.app')

@section('title', 'Edit Item')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Edit Item</h4>
    <a href="{{ route('admin.items.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i> Back to Items
    </a>
</div>

<!-- Debug Info -->
@if($errors->any())
<div class="alert alert-danger">
    <h5>Validation Errors:</h5>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.items.update', $item) }}" method="POST" enctype="multipart/form-data" id="itemForm">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Item Name (English) *</label>
                    <input type="text" class="form-control" name="name_en" value="{{ old('name_en', $item->name_en) }}" required>
                    @error('name_en')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Category *</label>
                    <select class="form-select" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name_en }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-4">
                    <label class="form-label">Item Name (Arabic)</label>
                    <input type="text" class="form-control" name="name_ar" value="{{ old('name_ar', $item->name_ar) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Item Name (Kurdish)</label>
                    <input type="text" class="form-control" name="name_ku" value="{{ old('name_ku', $item->name_ku) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Item Name (Turkish)</label>
                    <input type="text" class="form-control" name="name_tr" value="{{ old('name_tr', $item->name_tr) }}">
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label class="form-label">Item Name (Persian)</label>
                    <input type="text" class="form-control" name="name_fa" value="{{ old('name_fa', $item->name_fa) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Currency</label>
                    <select class="form-select" name="currency">
                        <option value="IQD" {{ old('currency', $item->currency) == 'IQD' ? 'selected' : '' }}>IQD - Iraqi Dinar</option>
                        <option value="USD" {{ old('currency', $item->currency) == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                    </select>
                </div>
            </div>

            <h6 class="mt-4 mb-3">Pricing Information</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Normal Price *</label>
                    <input type="number" class="form-control" name="normal_price" value="{{ old('normal_price', $item->normal_price) }}" step="0.01" min="0" required>
                    @error('normal_price')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Price With Ice Cream</label>
                    <input type="number" class="form-control" name="price_with_ice_cream" value="{{ old('price_with_ice_cream', $item->price_with_ice_cream) }}" step="0.01" min="0">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Price Per Kilo</label>
                    <input type="number" class="form-control" name="price_per_kilo" value="{{ old('price_per_kilo', $item->price_per_kilo) }}" step="0.01" min="0">
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label class="form-label">Cover Image</label>
                    <input type="file" class="form-control" name="cover_image" accept="image/*">
                    <div class="form-text">Main product image</div>

                    @if($item->cover_image)
                    <div class="mt-2">
                        <label class="form-label">Current Cover Image:</label>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset('storage/' . $item->cover_image) }}"
                                 alt="{{ $item->name_en }}"
                                 class="img-thumbnail"
                                 style="width: 80px; height: 60px; object-fit: cover;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remove_cover_image" value="1" id="removeCoverImage">
                                <label class="form-check-label small" for="removeCoverImage">
                                    Remove current cover image
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">Gallery Images</label>
                    <input type="file" class="form-control" name="gallery_images[]" multiple accept="image/*">
                    <div class="form-text">Multiple images for product gallery</div>

                    @if($item->gallery_images && count($item->gallery_images) > 0)
                    <div class="mt-2">
                        <label class="form-label">Current Gallery Images:</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($item->gallery_images as $galleryImage)
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $galleryImage) }}"
                                     alt="Gallery Image"
                                     class="img-thumbnail"
                                     style="width: 60px; height: 60px; object-fit: cover;">
                                <div class="form-check position-absolute top-0 start-0">
                                    <input class="form-check-input" type="checkbox" name="remove_gallery_images[]" value="{{ $galleryImage }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <small class="text-muted">Check images to remove</small>
                    </div>
                    @endif
                </div>
            </div>

            <div class="mt-4">
                <label class="form-label d-block mb-2">Status</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                        {{ old('is_active', $item->is_active) ? 'checked' : '' }}
                        style="width: 3em; height: 1.5em; background-color: #9859C5;">
                    <label class="form-check-label">Active Item</label>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.items.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-chip" id="submitBtn">
                    <i class="bi bi-check-circle me-2"></i> Update Item
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('itemForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Updating...';
});
</script>
@endsection
