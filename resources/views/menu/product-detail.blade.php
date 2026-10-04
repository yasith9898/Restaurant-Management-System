@extends('layouts.menu')

@section('content')
<div class="container-fluid p-0">
    <!-- Product Image -->
    <div class="product-image-container" style="height: 60vh;">
        <div class="image-slide" style="background-image: url('{{ asset($product->cover_image) }}'); height: 100%;">
            <div class="header-title">
                <button type="button" class="btn-close custom-close-btn" onclick="window.history.back()"></button>
                <h5 class="modal-title text-white">Baklava Inn</h5>
            </div>
        </div>
    </div>

    <!-- Product Details -->
    <div class="product-details-section">
        <div class="container-fluid p-0">
            <h2 class="product-name-heading mb-3">{{ $product->name }}</h2>

            @if($product->description)
            <p class="text-muted mb-4">{{ $product->description }}</p>
            @endif

            <div class="options-container">
                <h3 class="options-heading" data-translate="choose">Choose</h3>

                <!-- Normal Price -->
                @if($product->normal_price > 0)
                <div class="product-option d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                    <span class="option-label">Standard</span>
                    <span class="option-price fw-bold">{{ $product->formatted_price }}</span>
                </div>
                @endif

                <!-- Price with Ice Cream -->
                @if($product->price_with_ice_cream > 0)
                <div class="product-option d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                    <span class="option-label">With Ice Cream</span>
                    <span class="option-price fw-bold">{{ number_format($product->price_with_ice_cream, 0) }} {{ $product->currency }}</span>
                </div>
                @endif

                <!-- Price Per Kilo -->
                @if($product->price_per_kilo > 0)
                <div class="product-option d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                    <span class="option-label">Per Kilo</span>
                    <span class="option-price fw-bold">{{ number_format($product->price_per_kilo, 0) }} {{ $product->currency }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
