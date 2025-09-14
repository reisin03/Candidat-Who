@extends('layouts.guest')

@section('title', 'Admin Login')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #ffffff !important;
        min-height: 100vh;
        color: #333;
    }

    /* Flat styled card */
    .card {
        background: #ffffff !important; /* solid white background */
        color: #333 !important;
        border: 1px solid #667eea !important; /* thin gradient border */
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-radius: 12px;
    }

    .card-header {
        background: #f9f9f9 !important; /* light flat header */
        border-bottom: 1px solid #764ba2 !important;
        color: #333 !important;
        font-weight: 600;
    }

    /* Gradient buttons */
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        border: none !important;
        color: white !important;
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }
    .btn-primary:hover {
        filter: brightness(1.1);
        transform: scale(1.05);
    }

    /* Links matching theme */
    a {
        color: #667eea;
        text-decoration: none;
    }
    a:hover {
        color: #764ba2;
        text-decoration: underline;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: transparent;
        border: 2px solid #667eea; /* blue border for white background */
        color: #667eea; /* blue text */
        font-weight: 500;
        padding: 6px 14px;
        border-radius: 8px;
        transition: all 0.3s ease-in-out;
    }
    .btn-back:hover {
        background: #667eea; /* blue background on hover */
        color: #fff; /* white text on hover */
        transform: translateX(-3px);
        box-shadow: 0 3px 8px rgba(102,126,234,0.4);
    }

    /* Adjust SVG color */
    .btn-back svg {
        fill: currentColor; /* inherits text color */
    }
</style>

<div class="mb-3">
    <a href="{{ !str_contains(url()->previous(), 'admin/login') && !str_contains(url()->previous(), 'admin/register') && url()->previous() !== url()->current() ? url()->previous() : url('/') }}" class="btn-back">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
             class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                  d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0
                     1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        Back
    </a>
</div>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header text-center rounded-top">
                    <h4 class="mb-0">Admin Login</h4>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Admin Email" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
