@extends('layouts.app')

@section('title', 'Feedback Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Customer Feedback</h3>
                    <div class="card-tools">
                        <span class="badge badge-primary">Total: {{ $feedback->count() }}</span>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($feedback->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Staff Rating</th>
                                        <th>Service Rating</th>
                                        <th>Hygiene Rating</th>
                                        <th>Overall Experience</th>
                                        <th>Phone</th>
                                        <th>Comment</th>
                                        <th>Submitted At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($feedback as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                @if($item->staff_rating)
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <span style="color: {{ $i <= $item->staff_rating ? '#FFD700' : '#ccc' }}; font-size: 18px;">★</span>
                                                    @endfor
                                                    <br><small>({{ $item->staff_rating }}/5)</small>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->service_rating)
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <span style="color: {{ $i <= $item->service_rating ? '#FFD700' : '#ccc' }}; font-size: 18px;">★</span>
                                                    @endfor
                                                    <br><small>({{ $item->service_rating }}/5)</small>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->hygiene_rating)
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <span style="color: {{ $i <= $item->hygiene_rating ? '#FFD700' : '#ccc' }}; font-size: 18px;">★</span>
                                                    @endfor
                                                    <br><small>({{ $item->hygiene_rating }}/5)</small>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @switch($item->overall_experience)
                                                    @case('very-poor')
                                                        <span style="font-size: 20px;">😵</span> Very Poor
                                                        @break
                                                    @case('poor')
                                                        <span style="font-size: 20px;">😟</span> Poor
                                                        @break
                                                    @case('neutral')
                                                        <span style="font-size: 20px;">🙂</span> Neutral
                                                        @break
                                                    @case('good')
                                                        <span style="font-size: 20px;">😄</span> Good
                                                        @break
                                                    @case('excellent')
                                                        <span style="font-size: 20px;">🤩</span> Excellent
                                                        @break
                                                    @default
                                                        <span class="text-muted">N/A</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $item->phone ?? 'N/A' }}</td>
                                            <td>
                                                @if($item->comment)
                                                    @if(strlen($item->comment) > 50)
                                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#commentModal{{ $item->id }}">
                                                            View Comment
                                                        </button>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="commentModal{{ $item->id }}" tabindex="-1">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Comment #{{ $item->id }}</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        {{ $item->comment }}
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        {{ $item->comment }}
                                                    @endif
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->created_at->format('M j, Y g:i A') }}</td>
                                            <td>
                                                <form action="{{ route('admin.feedback.destroy', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this feedback?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <h5>No feedback submitted yet.</h5>
                            <p class="mb-0">Customer feedback will appear here once they start submitting.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Additional JavaScript if needed
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endsection
