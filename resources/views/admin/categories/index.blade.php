@extends('layouts.app')

@section('title', 'Categories Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Categories Management</h4>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-chip">
        <i class="bi bi-plus-circle me-2"></i> Add New Category
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Total Items</th>
                        <th>Created Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>CAT-{{ $category->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="fw-medium">{{ $category->name_en }}</div>
                            </div>
                        </td>
                        <td>
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name_en }}"
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div class="bg-light rounded" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="form-switch switch-purple d-inline-block">
                                <input class="form-check-input status-toggle" type="checkbox"
                                    data-id="{{ $category->id }}"
                                    {{ $category->is_active ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td>{{ $category->items_count }} Items</td>
                        <td>{{ $category->created_at->format('d-M-Y') }}</td>
                        <td class="text-end">
                            <div class="d-inline-flex">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this category?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="bi bi-inbox display-4 text-muted"></i>
                            <p class="text-muted mt-2">No categories found</p>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-chip btn-sm">
                                <i class="bi bi-plus-circle me-1"></i> Add First Category
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.status-toggle').change(function() {
        const categoryId = $(this).data('id');
        const isActive = $(this).is(':checked');

        $.ajax({
            url: "{{ url('admin/categories') }}/" + categoryId + "/toggle-status",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log('Status updated successfully');
            },
            error: function(xhr) {
                alert('Error updating status');
                location.reload();
            }
        });
    });
});
</script>
@endsection
