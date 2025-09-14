@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid p-2">
    @php
        $stats = [
            ['icon'=>'users','label'=>'Total Officials','value'=>\App\Models\Official::count() + \App\Models\RunningOfficial::count() + \App\Models\CurrentSk::count() + \App\Models\RunningSk::count()],
            ['icon'=>'comments','label'=>'Feedback','value'=>\App\Models\Feedback::count()],
            ['icon'=>'user-check','label'=>'Pending Users','value'=>\App\Models\User::where('verification_status', 'pending')->count()],
        ];
        
        // Add pending admin verifications for super admins
        if(auth('admin')->user()->isSuperAdmin()) {
            $stats[] = ['icon'=>'shield-alt','label'=>'Pending Admins','value'=>\App\Models\Admin::where('verification_status', 'pending')->count()];
        }
    @endphp

    <!-- Header with Stats -->
    <div class="card shadow-sm mb-2">
        <div class="card-body p-2">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h6 class="mb-0 text-primary">Welcome, {{ auth('admin')->user()->name ?? 'Admin' }}!</h6>
                    <small class="text-muted">{{ now()->format('M j, Y • g:i A') }}</small>
                </div>
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.verifications.users') }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-user-check"></i> Verify Users
                        @if(\App\Models\User::where('verification_status', 'pending')->count() > 0)
                            <span class="badge bg-danger ms-1">{{ \App\Models\User::where('verification_status', 'pending')->count() }}</span>
                        @endif
                    </a>
                    @if(auth('admin')->user()->isSuperAdmin())
                        <a href="{{ route('admin.verifications.admins') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-shield-alt"></i> Verify Admins
                            @if(\App\Models\Admin::where('verification_status', 'pending')->count() > 0)
                                <span class="badge bg-danger ms-1">{{ \App\Models\Admin::where('verification_status', 'pending')->count() }}</span>
                            @endif
                        </a>
                    @endif
                    <a href="{{ route('admin.runningofficials.create') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-user-plus"></i> Add Official
                    </a>
                    <a href="{{ route('admin.runningsk.create') }}" class="btn btn-info btn-sm">
                        <i class="fas fa-user-friends"></i> Add Running SK
                    </a>
                </div>
            </div>
            
            <!-- Inline Stats -->
            <div class="row g-1 justify-content-center">
                @foreach($stats as $stat)
                <div class="col-6 col-lg-3">
                    <div class="bg-light rounded p-2 text-center border">
                        <i class="fas fa-{{ $stat['icon'] }} text-primary mb-1"></i>
                        <div class="small text-muted">{{ $stat['label'] }}</div>
                        <div class="fw-bold text-dark">{{ $stat['value'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row g-2">
        <!-- Officials Management -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header py-2 px-3 bg-light border-bottom">
                    <h6 class="mb-0 text-dark"><i class="fas fa-users me-2 text-primary"></i>Officials Management</h6>
                </div>
                <div class="card-body p-2">
                    <div class="row g-1">
                        <div class="col-6 col-md-3">
                            <a href="{{ route('admin.brgyofficials.index') }}" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center py-2 text-decoration-none">
                                <i class="fas fa-building mb-1"></i>
                                <small class="text-dark">Barangay Officials</small>
                                <span class="badge bg-primary mt-1">{{ \App\Models\Official::count() }}</span>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="{{ route('admin.runningofficials.index') }}" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center py-2 text-decoration-none">
                                <i class="fas fa-running mb-1"></i>
                                <small class="text-dark">Running Officials</small>
                                <span class="badge bg-primary mt-1">{{ \App\Models\RunningOfficial::count() }}</span>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="{{ route('admin.currentsk.index') }}" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center py-2 text-decoration-none">
                                <i class="fas fa-users mb-1"></i>
                                <small class="text-dark">Current SK</small>
                                <span class="badge bg-primary mt-1">{{ \App\Models\CurrentSk::count() }}</span>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="{{ route('admin.runningsk.index') }}" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center py-2 text-decoration-none">
                                <i class="fas fa-user-friends mb-1"></i>
                                <small class="text-dark">Running SK</small>
                                <span class="badge bg-primary mt-1">{{ \App\Models\RunningSk::count() }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Feedback -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header py-2 px-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-dark"><i class="fas fa-comments me-2 text-success"></i>Recent Feedback</h6>
                    <a href="{{ route('admin.feedback.index') }}" class="btn btn-sm btn-outline-success">View All</a>
                </div>
                <div class="card-body p-2">
                    @if(\App\Models\Feedback::count() > 0)
                        @foreach(\App\Models\Feedback::latest()->take(4)->get() as $feedback)
                            <div class="d-flex mb-2 p-2 bg-light rounded border">
                                <div class="flex-shrink-0 me-2">
                                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                        <i class="fas fa-comment text-white small"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="small fw-semibold mb-1 text-dark">{{ Str::limit($feedback->message, 45) }}</div>
                                    <div class="small text-muted">
                                        {{ $feedback->created_at->diffForHumans() }}
                                        @if($feedback->rating)
                                            <span class="ms-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $feedback->rating ? 'text-warning' : 'text-muted' }}" style="font-size: 10px;"></i>
                                                @endfor
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-3">
                            <i class="fas fa-comments fa-2x mb-2 opacity-50"></i>
                            <div class="small">No feedback yet</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
