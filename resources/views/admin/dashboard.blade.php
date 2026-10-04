@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Dashboard</h4>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Total Categories</h6>
                        <h3 class="text-primary">{{ $stats['total_categories'] }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-grid-3x3-gap text-primary fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Total Items</h6>
                        <h3 class="text-success">{{ $stats['total_items'] }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-cart text-success fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Active Categories</h6>
                        <h3 class="text-info">{{ $stats['active_categories'] }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-check-circle text-info fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Active Items</h6>
                        <h3 class="text-warning">{{ $stats['active_items'] }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-check-square text-warning fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Items -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Recent Items</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentItems as $item)
                    <tr>
                        <td>{{ $item->name_en }}</td>
                        <td>{{ $item->category->name_en }}</td>
                        <td>{{ $item->formatted_price }}</td>
                        <td>
                            @if($item->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $item->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
