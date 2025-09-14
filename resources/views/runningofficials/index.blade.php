@extends('layouts.admin')
@section('title', 'Running Barangay Officials')

@section('content')
<div class="container">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Simple Header -->
    <div class="text-center my-4">
        <h1 class="display-6 fw-bold text-dark">Running Barangay Officials</h1>
        <p class="text-muted">Manage candidates running for office</p>
    </div>

    <!-- Barangay Captain Candidates -->
    <div class="text-center mb-4">
        <h4 class="text-dark">Barangay Captain Candidates</h4>
    </div>

    <div class="row g-3 justify-content-center mb-4">
        @forelse($captains as $captain)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100 text-center border-0 shadow-lg">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px;">
                        @if($captain->photo)
                            <img src="{{ asset('storage/'.$captain->photo) }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                        @endif
                    </div>
                    <h5 class="card-title">{{ $captain->fname }} {{ $captain->middle_initial ? $captain->middle_initial . ' ' : '' }}{{ $captain->lname }}</h5>
                    <p class="text-muted">{{ $captain->position }}</p>
                    <a href="{{ route('runningofficials.show', $captain->id) }}" class="btn btn-primary w-100">View Profile</a>

                    {{-- Admin Controls --}}
                    @if(auth('admin')->check())
                        <div class="mt-2">
                            <a href="{{ route('admin.runningofficials.edit', $captain) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                            <form action="{{ route('admin.runningofficials.mark-winner', $captain) }}" method="POST" class="d-inline me-1" id="mark-winner-form-{{ $captain->id }}">
                                @csrf
                                <button type="button" onclick="submitMarkWinner({{ $captain->id }})" class="btn btn-sm btn-success">Mark as Winner</button>
                            </form>
                            <form action="{{ route('admin.runningofficials.destroy', $captain) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
            <div class="col-12">
                <div class="card text-center border-0">
                    <div class="card-body py-5">
                        <h5 class="text-muted">No Captain Candidates Available</h5>
                        <p class="text-muted">Check back later for election updates.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Barangay Kagawads -->
    <div class="text-center mb-4">
        <h4 class="text-dark">Barangay Kagawad Candidates</h4>
    </div>

    <div class="row g-3 justify-content-center">
        @forelse($kagawads as $kagawad)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100 text-center border-0 shadow">
                <div class="card-body">
                    @if($kagawad->photo)
                        <img src="{{ asset('storage/'.$kagawad->photo) }}" class="rounded-circle mb-3" style="width: 60px; height: 60px; object-fit: cover;">
                    @else
                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        </div>
                    @endif
                    <h6 class="card-title">{{ $kagawad->fname }} {{ $kagawad->middle_initial ? $kagawad->middle_initial . ' ' : '' }}{{ $kagawad->lname }}</h6>
                    <p class="text-muted small">{{ $kagawad->position }}</p>
                    <a href="{{ route('runningofficials.show', $kagawad->id) }}" class="btn btn-outline-primary btn-sm w-100">View Profile</a>

                    {{-- Admin Controls --}}
                    @if(auth('admin')->check())
                        <div class="mt-2">
                            <a href="{{ route('admin.runningofficials.edit', $kagawad) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                            <form action="{{ route('admin.runningofficials.mark-winner', $kagawad) }}" method="POST" class="d-inline me-1" id="mark-winner-form-{{ $kagawad->id }}">
                                @csrf
                                <button type="button" onclick="submitMarkWinner({{ $kagawad->id }})" class="btn btn-sm btn-success">Mark as Winner</button>
                            </form>
                            <form action="{{ route('admin.runningofficials.destroy', $kagawad) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
            <div class="col-12">
                <div class="card text-center border-0">
                    <div class="card-body py-5">
                        <h5 class="text-muted">No Kagawad Candidates Available</h5>
                        <p class="text-muted">Check back later for election updates.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Back to Home -->
    <div class="text-center mt-4">
        <a href="{{ route('admin.home') }}" class="btn btn-light">
            <i class="fas fa-home me-2"></i>Back to Dashboard
        </a>
    </div>
</div>
@endsection

<script>
function submitMarkWinner(officialId) {
    if (confirm('Mark this official as election winner? They will be promoted to current officials.')) {
        console.log('Submitting form for official ID:', officialId);
        document.getElementById('mark-winner-form-' + officialId).submit();
    } else {
        console.log('User cancelled the action');
    }
}
</script>