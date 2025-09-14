@extends('layouts.admin')
@section('title', 'Barangay Officials')

@section('content')
<div class="container">
    <!-- Simple Header -->
    <div class="text-center my-4">
        <h1 class="display-6 fw-bold text-dark">Barangay Officials</h1>
        <p class="text-muted">Meet your current elected leaders</p>
    </div>

    <!-- Barangay Captain -->
    @if($captain)
    <div class="row justify-content-center mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 text-center border-0 shadow-lg">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px;">
                        @if($captain->photo)
                            <img src="{{ asset('storage/'.$captain->photo) }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                        @endif
                    </div>
                    <h5 class="card-title">{{ $captain->fname }} {{ $captain->middle_initial ? $captain->middle_initial . ' ' : '' }}{{ $captain->lname }}</h5>
                    <p class="text-muted">{{ $captain->position }}</p>
                    <a href="{{ route('brgyofficials.show', $captain->id) }}" class="btn btn-primary w-100">View Profile</a>

                    {{-- Admin Controls --}}
                    @if(auth('admin')->check())
                        <div class="mt-2">
                            <a href="{{ route('admin.brgyofficials.edit', $captain) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                            <form action="{{ route('admin.brgyofficials.destroy', $captain) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Barangay Kagawads -->
    <div class="text-center mb-4">
        <h4 class="text-dark">Barangay Kagawads</h4>
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
                    <a href="{{ route('brgyofficials.show', $kagawad->id) }}" class="btn btn-outline-primary btn-sm w-100">View Profile</a>

                    {{-- Admin Controls --}}
                    @if(auth('admin')->check())
                        <div class="mt-2">
                            <a href="{{ route('admin.brgyofficials.edit', $kagawad) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                            <form action="{{ route('admin.brgyofficials.destroy', $kagawad) }}" method="POST" class="d-inline">
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
                        <h5 class="text-muted">No Kagawads Available</h5>
                        <p class="text-muted">Check back later for updates.</p>
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