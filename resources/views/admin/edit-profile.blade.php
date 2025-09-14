@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <a href="{{ route('admin.profile') }}" class="btn btn-outline-secondary mb-3">← Back to Profile</a>
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white">Edit Profile</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $admin->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Profile Picture</label>
                    <input type="file" name="profile_picture" class="form-control">
                    @if($admin->profile_picture)
                        <img src="{{ asset('storage/' . $admin->profile_picture) }}" 
                             class="rounded mt-2" width="100" height="100">
                    @endif
                </div>

                <button type="submit" class="btn btn-success">Save Changes</button>
                <a href="{{ route('admin.profile') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
