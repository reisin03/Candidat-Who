@extends('layouts.admin')

@section('title', 'Feedback Management')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary">Feedback Management</h1>
        <p class="text-muted">View and manage all user feedback</p>
    </div>

    <!-- Feedback List -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($feedbacks->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Rating</th>
                                <th>Related To</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feedbacks as $feedback)
                                <tr>
                                    <td>{{ $feedback->id }}</td>
                                    <td>
                                        @if($feedback->user)
                                            {{ $feedback->user->name ?? 'N/A' }}
                                        @else
                                            <span class="text-muted">Anonymous</span>
                                        @endif
                                    </td>
                                    <td>{{ $feedback->subject ?? 'N/A' }}</td>
                                    <td>
                                        <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            {{ $feedback->message }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($feedback->rating)
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $feedback->rating)
                                                    <i class="fas fa-star text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-muted"></i>
                                                @endif
                                            @endfor
                                            ({{ $feedback->rating }}/5)
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($feedback->feedbackable)
                                            {{ class_basename($feedback->feedbackable_type) }} #{{ $feedback->feedbackable_id }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $feedback->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $feedbacks->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No Feedback Yet</h4>
                    <p class="text-muted">There are no feedback entries to display.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection