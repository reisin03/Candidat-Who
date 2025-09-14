@php
    $isAdmin = str_starts_with(request()->route()->getName(), 'admin.') ||
               auth('admin')->check() ||
               str_contains(request()->path(), 'admin');
    $isUser = auth('web')->check() && !$isAdmin;
    $layout = $isAdmin ? 'layouts.admin' : ($isUser ? 'layouts.user' : 'layouts.app');
@endphp
@extends($layout)

@section('title', 'Current Official Details')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary">Current Official Details</h1>
        <p class="text-muted">Detailed information about the current official.</p>
    </div>

    <!-- Official Details -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="background-color: #f8f9fa;">
                <div class="card-body text-center">
                    <img src="{{ $official->photo ? asset('storage/'.$official->photo) : 'https://via.placeholder.com/200' }}"
                         alt="Running Official Photo"
                         class="rounded-circle mb-4 border border-3"
                         style="border-color: #cce5ff; width: 200px; height: 200px; object-fit: cover;">

                    <h3 class="card-title fw-bold text-dark mb-3">
                        {{ $official->fname }} {{ $official->middle_initial ? $official->middle_initial . ' ' : '' }}{{ $official->lname }}
                    </h3>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Position</h6>
                            <p class="fw-bold">{{ $official->position }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Age</h6>
                            <p class="fw-bold">{{ $official->age ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Gender</h6>
                            <p class="fw-bold">{{ $official->gender ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Birthdate</h6>
                            <p class="fw-bold">{{ $official->birthdate ? \Carbon\Carbon::parse($official->birthdate)->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>

                    @if($official->address)
                    <div class="mb-4">
                        <h6 class="text-muted">Address</h6>
                        <p class="fw-bold">{{ $official->address }}</p>
                    </div>
                    @endif

                    @if($official->email || $official->phone)
                    <div class="mb-4">
                        <h6 class="text-muted">Contact Information</h6>
                        @if($official->phone)
                        <p class="mb-1"><i class="fas fa-phone"></i> {{ $official->phone }}</p>
                        @endif
                        @if($official->email)
                        <p class="mb-1"><i class="fas fa-envelope"></i> {{ $official->email }}</p>
                        @endif
                    </div>
                    @endif

                    @if($official->platform && count($official->platform) > 0)
                    <div class="mb-4">
                        <button class="btn btn-link p-0 text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#platformCollapse{{ $official->id }}" aria-expanded="false" aria-controls="platformCollapse{{ $official->id }}">
                            <h6 class="text-muted mb-0">
                                <i class="fas fa-chevron-down me-2"></i>Platform
                            </h6>
                        </button>
                        <div class="collapse" id="platformCollapse{{ $official->id }}">
                            <div class="mt-3">
                                <ul class="list-unstyled">
                                    @foreach($official->platform as $item)
                                        <li class="mb-1">• {{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($official->credentials && count($official->credentials) > 0)
                    <div class="mb-4">
                        <button class="btn btn-link p-0 text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#credentialsCollapse{{ $official->id }}" aria-expanded="false" aria-controls="credentialsCollapse{{ $official->id }}">
                            <h6 class="text-muted mb-0">
                                <i class="fas fa-chevron-down me-2"></i>Credentials
                            </h6>
                        </button>
                        <div class="collapse" id="credentialsCollapse{{ $official->id }}">
                            <div class="mt-3">
                                <ul class="list-unstyled">
                                    @foreach($official->credentials as $item)
                                        <li class="mb-1">• {{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

    <!-- Latest Feedback Display (for everyone) -->
    @if($official->feedbacks->count() > 0)
    <div class="mb-4">
        <h6 class="text-muted mb-3">Latest User Feedback:</h6>
        @php
            $latestFeedback = $official->feedbacks->sortByDesc('created_at')->first();
        @endphp
        <div class="border p-3 mb-3 bg-light rounded">
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <p class="mb-2"><strong>Message:</strong> {{ $latestFeedback->message }}</p>
                    @if($latestFeedback->rating)
                        <p class="mb-1"><strong>Rating:</strong>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $latestFeedback->rating)
                                    <i class="fas fa-star text-warning"></i>
                                @else
                                    <i class="far fa-star text-muted"></i>
                                @endif
                            @endfor
                            ({{ $latestFeedback->rating }}/5)
                        </p>
                    @endif
                </div>
                <small class="text-muted">{{ $latestFeedback->created_at->format('M d, Y') }}</small>
            </div>
        </div>
        @if($official->feedbacks->count() > 1)
            <p class="text-muted small">Showing latest feedback. {{ $official->feedbacks->count() - 1 }} more feedback{{ $official->feedbacks->count() - 1 > 1 ? 's' : '' }} available.</p>
        @endif
    </div>
    @endif

    <!-- Feedback Form (only for users) -->
    @auth('web') <!-- Only show to authenticated users -->
    <div class="mb-4">
        <h6 class="text-muted mb-3">Submit Your Feedback:</h6>
        <form method="POST" action="{{ route('feedback.store') }}">
            @csrf
            <input type="hidden" name="feedbackable_type" value="{{ get_class($official) }}">
            <input type="hidden" name="feedbackable_id" value="{{ $official->id }}">

            <div class="mb-3">
                <label for="message" class="form-label">Your Feedback</label>
                <textarea name="message" class="form-control" rows="3" placeholder="Share your thoughts about this official..." required></textarea>
            </div>

            <div class="mb-3">
                <label for="rating" class="form-label">Rating (1-5 stars)</label>
                <select name="rating" class="form-select" required>
                    <option value="">Select a rating</option>
                    <option value="5">★★★★★ (5) - Excellent</option>
                    <option value="4">★★★★☆ (4) - Very Good</option>
                    <option value="3">★★★☆☆ (3) - Good</option>
                    <option value="2">★★☆☆☆ (2) - Fair</option>
                    <option value="1">★☆☆☆☆ (1) - Poor</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Submit Feedback</button>
        </form>
    </div>
    @endauth

    @if(!auth('admin')->check()) <!-- Show login prompt for non-admin users -->
    <div class="mb-4 text-center">
        <div class="alert alert-info">
            <h6>Want to share your feedback?</h6>
            <p class="mb-2">Please <a href="{{ route('user.login') }}" class="alert-link">login</a> to submit feedback and ratings for officials.</p>
        </div>
    </div>
    @endif

    <!-- Footer Note -->
    <div class="mt-5 p-4 text-center rounded" style="background-color: #e6f2ff;">
        <h5 class="fw-bold mb-1">Serving the People</h5>
        <p class="mb-0">Our officials are committed to making our barangay a better place for everyone.</p>
    </div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle collapse show/hide for platform and credentials
    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
        button.addEventListener('click', function() {
            const icon = this.querySelector('i');
            const target = document.querySelector(this.getAttribute('data-bs-target'));

            if (target.classList.contains('show')) {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            } else {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        });
    });
});
</script>
