@extends('layouts.user')
@section('title', 'Welcome to Candidat.Who?')

@section('content')
<div class="container">
    <!-- Welcome Section -->
    <div class="text-center my-5">
        <h1 class="display-5 fw-bold">Welcome, {{ auth('web')->user()->name ?? 'User' }}!</h1>
        <p class="lead text-muted">Explore your barangay's leaders and share your feedback</p>
    </div>

    <!-- Search Bar -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('search') }}" method="GET" class="d-flex">
                        <input type="text"
                               name="query"
                               class="form-control form-control-lg"
                               placeholder="Search for officials, candidates, or leaders..."
                               value="{{ request('query') }}"
                               required>
                        <button type="submit" class="btn btn-primary btn-lg ms-2">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <div class="text-center mt-2">
                        <small class="text-muted">Search by name, position, or location</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Categories -->
    <div class="row g-4 justify-content-center">
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 text-center shadow-sm">
                <div class="card-body">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-user-tie fa-2x text-secondary"></i>
                    </div>
                    <h5 class="card-title">Barangay Officials</h5>
                    <p class="card-text text-muted small">Current elected leaders</p>
                    <a href="{{ route('brgyofficials.index') }}" class="btn btn-outline-primary w-100">View Officials</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card h-100 text-center shadow-sm">
                <div class="card-body">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-user-plus fa-2x text-secondary"></i>
                    </div>
                    <h5 class="card-title">Running Candidates</h5>
                    <p class="card-text text-muted small">People running for office</p>
                    <a href="{{ route('runningofficials.index') }}" class="btn btn-outline-primary w-100">View Candidates</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card h-100 text-center shadow-sm">
                <div class="card-body">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-users-cog fa-2x text-secondary"></i>
                    </div>
                    <h5 class="card-title">Current SK</h5>
                    <p class="card-text text-muted small">Youth leaders</p>
                    <a href="{{ route('currentsk.index') }}" class="btn btn-outline-primary w-100">View SK Leaders</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card h-100 text-center shadow-sm">
                <div class="card-body">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-user-friends fa-2x text-secondary"></i>
                    </div>
                    <h5 class="card-title">Running SK</h5>
                    <p class="card-text text-muted small">Youth candidates</p>
                    <a href="{{ route('runningsk.index') }}" class="btn btn-outline-primary w-100">View SK Candidates</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Community Stats -->
    <div class="row mt-5 justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title mb-3">Community Overview</h5>
                    <div class="row">
                        <div class="col-6">
                            <div class="h3 mb-1">{{ \App\Models\Official::count() + \App\Models\RunningOfficial::count() + \App\Models\CurrentSk::count() + \App\Models\RunningSk::count() }}</div>
                            <small class="text-muted">Total Leaders</small>
                        </div>
                        <div class="col-6">
                            <div class="h3 mb-1">{{ \App\Models\Feedback::count() }}</div>
                            <small class="text-muted">Community Feedback</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Footer Link -->
    <div class="text-center mt-5">
        <p class="text-muted">
            Want to learn more about our platform?
            <a href="{{ route('objectives.show') }}" class="text-decoration-none">Learn More</a>
        </p>
    </div>
</div>
@endsection
