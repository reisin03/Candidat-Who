@extends('layouts.admin')
@section('title', 'Running SK Officials')

@section('content')
<div class="container">
    <!-- Simple Header -->
    <div class="text-center my-4">
        <h1 class="display-6 fw-bold text-dark">Running SK Officials</h1>
        <p class="text-muted">Manage youth candidates running for SK office</p>
    </div>

    <!-- SK Chairperson Candidates -->
    <div class="text-center mb-4">
        <h4 class="text-dark">SK Chairperson Candidates</h4>
    </div>

    <div class="row g-3 justify-content-center mb-4">
        @forelse($chairpersons as $chairperson)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100 text-center border-0 shadow-lg">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px;">
                        @if($chairperson->photo)
                            <img src="{{ asset('storage/'.$chairperson->photo) }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                        @endif
                    </div>
                    <h5 class="card-title">{{ $chairperson->fname }} {{ $chairperson->middle_initial ? $chairperson->middle_initial . ' ' : '' }}{{ $chairperson->lname }}</h5>
                    <p class="text-muted">{{ $chairperson->position }}</p>
                    <a href="{{ route('runningsk.show', $chairperson->id) }}" class="btn btn-primary w-100">View Profile</a>

                    {{-- Admin Controls --}}
                    @if(auth('admin')->check())
                        <div class="mt-2">
                            <a href="{{ route('admin.runningsk.edit', $chairperson) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                            <form action="{{ route('admin.runningsk.mark-winner', $chairperson) }}" method="POST" class="d-inline me-1">
                                @csrf
                                <button onclick="return confirm('Mark this SK official as election winner? They will be promoted to current SK officials.')" class="btn btn-sm btn-success">Mark as Winner</button>
                            </form>
                            <form action="{{ route('admin.runningsk.destroy', $chairperson) }}" method="POST" class="d-inline">
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
                        <h5 class="text-muted">No Chairperson Candidates Available</h5>
                        <p class="text-muted">Check back later for election updates.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- SK Members -->
    <div class="text-center mb-4">
        <h4 class="text-dark">SK Member Candidates</h4>
    </div>

    <div class="row g-3 justify-content-center">
        @forelse($members as $member)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100 text-center border-0 shadow">
                <div class="card-body">
                    @if($member->photo)
                        <img src="{{ asset('storage/'.$member->photo) }}" class="rounded-circle mb-3" style="width: 60px; height: 60px; object-fit: cover;">
                    @else
                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        </div>
                    @endif
                    <h6 class="card-title">{{ $member->fname }} {{ $member->middle_initial ? $member->middle_initial . ' ' : '' }}{{ $member->lname }}</h6>
                    <p class="text-muted small">{{ $member->position }}</p>
                    <a href="{{ route('runningsk.show', $member->id) }}" class="btn btn-outline-primary btn-sm w-100">View Profile</a>

                    {{-- Admin Controls --}}
                    @if(auth('admin')->check())
                        <div class="mt-2">
                            <a href="{{ route('admin.runningsk.edit', $member) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                            <form action="{{ route('admin.runningsk.mark-winner', $member) }}" method="POST" class="d-inline me-1">
                                @csrf
                                <button onclick="return confirm('Mark this SK official as election winner? They will be promoted to current SK officials.')" class="btn btn-sm btn-success">Mark as Winner</button>
                            </form>
                            <form action="{{ route('admin.runningsk.destroy', $member) }}" method="POST" class="d-inline">
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
                        <h5 class="text-muted">No SK Member Candidates Available</h5>
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