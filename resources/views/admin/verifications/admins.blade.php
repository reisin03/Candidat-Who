@extends('layouts.admin')
@section('title', 'Admin Verifications')

@section('content')
<div class="container-fluid p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-dark">Pending Admin Verifications</h4>
        <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="alert alert-info">
        <i class="fas fa-shield-alt me-2"></i>
        <strong>Super Admin Access:</strong> Only Admins can verify other admin accounts. Use caution when granting admin privileges.
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Admins Awaiting Verification ({{ $pendingAdmins->total() }})</h6>
        </div>
        <div class="card-body p-0">
            @if($pendingAdmins->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registered</th>
                                <th>ID Document</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingAdmins as $admin)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($admin->profile_picture)
                                            <img src="{{ asset('storage/'.$admin->profile_picture) }}" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="fas fa-shield-alt text-white small"></i>
                                            </div>
                                        @endif
                                        <strong>{{ $admin->name }}</strong>
                                    </div>
                                </td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    <small class="text-muted">{{ $admin->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    @if($admin->id_document)
                                        <a href="{{ route('admin.verifications.view', ['type' => 'admin', 'id' => $admin->id]) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="fas fa-eye me-1"></i>View ID
                                        </a>
                                    @else
                                        <span class="text-muted">No document</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.verifications.admin.show', $admin) }}" class="btn btn-outline-info">
                                            <i class="fas fa-eye"></i> Review
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="p-3">
                    {{ $pendingAdmins->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h5 class="text-muted">No Pending Admin Verifications</h5>
                    <p class="text-muted">All admin accounts have been verified or there are no new registrations.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection