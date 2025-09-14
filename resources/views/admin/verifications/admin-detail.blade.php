@extends('layouts.admin')
@section('title', 'Admin Verification - ' . $admin->name)

@section('content')
<div class="container-fluid p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-dark">Admin Verification Review</h4>
        <a href="{{ route('admin.verifications.admins') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="row">
        <!-- Admin Information -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Admin Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Full Name</label>
                                <p class="form-control-plaintext">{{ $admin->name }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email Address</label>
                                <p class="form-control-plaintext">{{ $admin->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Registration Date</label>
                                <p class="form-control-plaintext">{{ $admin->created_at->format('M j, Y g:i A') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-warning">{{ ucfirst($admin->verification_status) }}</span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Profile Picture</label>
                                <div>
                                    @if($admin->profile_picture)
                                        <img src="{{ asset('storage/'.$admin->profile_picture) }}" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="fas fa-shield-alt text-white"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ID Document -->
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-id-card me-2"></i>ID Document</h6>
                </div>
                <div class="card-body">
                    @if($admin->id_document)
                        <div class="text-center">
                            @if(Str::endsWith($admin->id_document, '.pdf'))
                                <div class="mb-3">
                                    <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                    <p class="mt-2">PDF Document</p>
                                </div>
                            @else
                                <img src="{{ asset('storage/'.$admin->id_document) }}" class="img-fluid rounded border" style="max-height: 400px;">
                            @endif
                            <div class="mt-3">
                                <a href="{{ route('admin.verifications.view', ['type' => 'admin', 'id' => $admin->id]) }}" class="btn btn-primary me-2" target="_blank">
                                    <i class="fas fa-eye me-1"></i>View Document
                                </a>
                                <a href="{{ route('admin.verifications.download', ['type' => 'admin', 'id' => $admin->id]) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-download me-1"></i>Download
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                            <p>No ID document uploaded</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Verification Actions -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-gavel me-2"></i>Verification Decision</h6>
                </div>
                <div class="card-body">
                    <!-- Approve Form -->
                    <form action="{{ route('admin.verifications.admin.approve', $admin) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="mb-3">
                            <label for="approve_notes" class="form-label">Approval Notes (Optional)</label>
                            <textarea name="notes" id="approve_notes" class="form-control" rows="3" placeholder="Add any notes about the verification..."></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_super_admin" id="is_super_admin" value="1">
                                <label class="form-check-label" for="is_super_admin">
                                    <strong>Grant Super Admin Privileges</strong>
                                    <small class="d-block text-muted">Super Admins can verify other admins and have full system access.</small>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Are you sure you want to approve this admin?')">
                            <i class="fas fa-check me-1"></i>Approve Admin
                        </button>
                    </form>

                    <hr>

                    <!-- Reject Form -->
                    <form action="{{ route('admin.verifications.admin.reject', $admin) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="reject_notes" class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                            <textarea name="notes" id="reject_notes" class="form-control" rows="3" placeholder="Explain why this admin verification is being rejected..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to reject this admin? They will not be able to access the admin system.')">
                            <i class="fas fa-times me-1"></i>Reject Admin
                        </button>
                    </form>
                </div>
            </div>

            <!-- Verification Guidelines -->
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Admin Verification Guidelines</h6>
                </div>
                <div class="card-body">
                    <ul class="small mb-0">
                        <li>Verify the ID document is clear and readable</li>
                        <li>Check that the name matches the registration</li>
                        <li>Look for signs of document tampering</li>
                        <li>Verify the ID is a valid government-issued document</li>
                        <li>Consider if this person should have admin privileges</li>
                        <li><strong>Use extreme caution when granting Super Admin status</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection