@extends('layouts.guest')
@section('title', 'Current SK Officials')

@section('content')
<div class="container">
    <!-- Simple Header -->
    <div class="text-center my-4">
        <h1 class="display-6 fw-bold text-primary">Current SK Officials</h1>
        <p class="text-muted">Meet our youth leaders</p>
    </div>

    <!-- SK Chairperson -->
    @if($chairperson)
    <div class="row justify-content-center mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 text-center border-0 shadow-lg">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px;">
                        @if($chairperson->photo)
                            <img src="{{ asset('storage/'.$chairperson->photo) }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                        @endif
                    </div>
                    <h5 class="card-title">{{ $chairperson->fname }} {{ $chairperson->middle_initial ? $chairperson->middle_initial . ' ' : '' }}{{ $chairperson->lname }}</h5>
                    <p class="text-muted">{{ $chairperson->position }}</p>
                    <a href="{{ route('currentsk.show', $chairperson->id) }}" class="btn btn-primary w-100">View Profile</a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- SK Members -->
    <div class="text-center mb-4">
        <h4 class="text-primary">SK Members</h4>
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
                    <a href="{{ route('currentsk.show', $member->id) }}" class="btn btn-outline-primary btn-sm w-100">View Profile</a>
                </div>
            </div>
        </div>
        @empty
            <div class="col-12">
                <div class="card text-center border-0">
                    <div class="card-body py-5">
                        <h5 class="text-muted">No SK Members Available</h5>
                        <p class="text-muted">Check back later for updates.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Back to Home -->
    <div class="text-center mt-4">
        @if(auth('web')->check())
            <a href="{{ route('user.home') }}" class="btn btn-light">
                <i class="fas fa-home me-2"></i>Back to Dashboard
            </a>
        @else
            <a href="{{ route('landing') }}" class="btn btn-light">
                <i class="fas fa-home me-2"></i>Back to Home
            </a>
        @endif
    </div>
</div>
@endsection
<style>
        body {
            background-color: #ffffff !important;
            min-height: 100vh;
            color: #333;
        }
        .hero-section {
            padding: 50px 0;
            text-align: center;
        }
        .feature-card {
            background: rgba(0, 123, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
            transition: transform 0.3s;
            border: 1px solid rgba(0, 123, 255, 0.2);
        }
        .feature-card:hover {
            transform: translateY(-5px);
            background: rgba(0, 123, 255, 0.15);
        }
        .btn-custom {
            background: rgba(0, 123, 255, 0.1);
            border: 1px solid rgba(0, 123, 255, 0.3);
            color: #007bff;
            padding: 12px 30px;
            border-radius: 25px;
            transition: all 0.3s;
            margin: 10px;
            text-decoration: none;
        }
        .btn-custom:hover {
            background: rgba(0, 123, 255, 0.2);
            color: #0056b3;
            transform: scale(1.05);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
    </style>