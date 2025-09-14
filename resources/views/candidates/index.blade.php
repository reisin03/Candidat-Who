@extends($layout ?? 'layouts.user')

@section('content')
<div class="container mt-4">
    @php
        $isAdmin = isset($layout) && $layout === 'layouts.admin';
    @endphp

    @if($isAdmin)
        <!-- Admin Search Form -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-8 col-lg-6">
                <div class="card bg-light border-0 shadow-lg">
                    <div class="card-body">
                        <form action="{{ route('admin.candidates.index') }}" method="GET" class="d-flex">
                            <input type="text"
                                   name="query"
                                   class="form-control form-control-lg"
                                   placeholder="Search for officials, candidates, or leaders..."
                                   value="{{ request('query') }}"
                                   required>
                            <button type="submit" class="btn btn-success btn-lg ms-2">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                        <div class="text-center mt-2">
                            <small class="text-muted">Search by name, position, or location</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- User Search Form -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-8 col-lg-6">
                <div class="card bg-light border-0 shadow-lg">
                    <div class="card-body">
                        <form action="{{ route('search') }}" method="GET" class="d-flex">
                            <input type="text"
                                   name="query"
                                   class="form-control form-control-lg"
                                   placeholder="Search for officials by name..."
                                   value="{{ request('query') }}"
                                   required>
                            <button type="submit" class="btn btn-primary btn-lg ms-2">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                        <div class="text-center mt-2">
                            <small class="text-muted">Search by official name, position, or location</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($query)
        <h3>Search Results for "{{ $query }}"</h3>
    @else
        <h3>All Candidates</h3>
    @endif
    <ul class="list-group mt-3">
        @forelse($candidates as $candidate)
            @php
                $fullName = '';
                if (isset($candidate->name)) {
                    $fullName = $candidate->name;
                } elseif (isset($candidate->fname)) {
                    $fullName = $candidate->fname;
                    if (isset($candidate->middle_initial) && $candidate->middle_initial) {
                        $fullName .= ' ' . $candidate->middle_initial;
                    }
                    if (isset($candidate->lname)) {
                        $fullName .= ' ' . $candidate->lname;
                    }
                }

                // Determine the correct show route based on model type and context
                $showRoute = '';
                $modelClass = get_class($candidate);
                $isAdmin = isset($layout) && $layout === 'layouts.admin';

                if ($modelClass === 'App\Models\Official') {
                    $showRoute = $isAdmin ? route('admin.brgyofficials.show', $candidate->id) : route('brgyofficials.show', $candidate->id);
                } elseif ($modelClass === 'App\Models\RunningOfficial') {
                    $showRoute = $isAdmin ? route('admin.runningofficials.show', $candidate->id) : route('runningofficials.show', $candidate->id);
                } elseif ($modelClass === 'App\Models\CurrentSk') {
                    $showRoute = $isAdmin ? route('admin.currentsk.show', $candidate->id) : route('currentsk.show', $candidate->id);
                } elseif ($modelClass === 'App\Models\RunningSk') {
                    $showRoute = $isAdmin ? route('admin.runningsk.show', $candidate->id) : route('runningsk.show', $candidate->id);
                }
            @endphp

            <a href="{{ $showRoute }}" class="text-decoration-none">
                <li class="list-group-item d-flex align-items-center hover-shadow" style="cursor: pointer; transition: all 0.2s;">
                    @if(isset($candidate->photo) && $candidate->photo)
                        <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $fullName }}" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}" alt="No Photo" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                    @endif
                    <div class="flex-grow-1">
                        <strong>Name:</strong> {{ $fullName }}<br>
                        @isset($candidate->position)
                            <strong>Position:</strong> {{ $candidate->position }}<br>
                        @endisset
                        @isset($candidate->age)
                            <strong>Age:</strong> {{ $candidate->age }}<br>
                        @endisset
                        @isset($candidate->gender)
                            <strong>Gender:</strong> {{ $candidate->gender }}<br>
                        @endisset
                        @isset($candidate->email)
                            <strong>Email:</strong> {{ $candidate->email }}<br>
                        @endisset
                        @isset($candidate->phone)
                            <strong>Phone:</strong> {{ $candidate->phone }}<br>
                        @endisset
                        @isset($candidate->platform)
                            <strong>Platform:</strong> {{ $candidate->platform }}<br>
                        @endisset
                        @isset($candidate->credentials)
                            <strong>Credentials:</strong> {{ $candidate->credentials }}<br>
                        @endisset
                        @isset($candidate->description)
                            <strong>Description:</strong> {{ $candidate->description }}<br>
                        @endisset
                    </div>
                    <div class="text-end">
                        <small class="text-muted">Click to view details →</small>
                    </div>
                </li>
            </a>
        @empty
            <li class="list-group-item">No candidates found.</li>
        @endforelse
    </ul>

    <div class="text-center mt-4">
        @php
            $isAdmin = isset($layout) && $layout === 'layouts.admin';
            $dashboardRoute = $isAdmin ? route('admin.home') : route('user.home');
            $dashboardText = $isAdmin ? 'Back to Admin Dashboard' : 'Back to Dashboard';
        @endphp
        <a href="{{ $dashboardRoute }}" class="btn btn-light">
            <i class="bi bi-house me-2"></i>{{ $dashboardText }}
        </a>
    </div>
</div>
@endsection

<style>
.hover-shadow:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
    transform: translateY(-2px);
    transition: all 0.2s ease;
}

.list-group-item {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    margin-bottom: 0.5rem;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}
</style>
