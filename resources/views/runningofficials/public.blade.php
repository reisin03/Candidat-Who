@extends('layouts.guest')
@section('title', 'Running Barangay Officials')

@section('content')
<div class="container">
    <!-- Simple Header -->
    <div class="text-center my-4">
        <h1 class="display-6 fw-bold text-primary">Running Barangay Officials</h1>
        <p class="text-muted">Meet the candidates running for office</p>
    </div>

    <!-- Barangay Captain Candidates -->
    <div class="text-center mb-4">
        <h4 class="text-primary">Barangay Captain Candidates</h4>
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
        <h4 class="text-primary">Barangay Kagawad Candidates</h4>
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