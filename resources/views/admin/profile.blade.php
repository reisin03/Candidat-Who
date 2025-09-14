@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <!-- ✅ Animated Back Button -->
    <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary mb-3 back-btn text-white">
        ← Back
    </a>

    <div class="card shadow-lg border-0">
        <div class="card-body text-center">
            <img src="{{ $admin->profile_picture ? asset('storage/' . $admin->profile_picture) : 'https://via.placeholder.com/150' }}"
                 class="mb-3"
                 style="border-radius: 50%; width: 150px; height: 150px; object-fit: cover;"
                 alt="Profile Picture">

            <h3>{{ $admin->name }}</h3>
            <p class="text-muted">Administrator</p>

            <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
        </div>
    </div>
</div>

<!-- ✅ Animation CSS -->
@push('styles')
<style>
    .back-btn {
        transition: all 0.3s ease;
    }
    .back-btn:hover {
        transform: translateX(-5px);
        background-color: #6c757d;
        color: #fff;
    }
</style>
@endpush
@endsection
