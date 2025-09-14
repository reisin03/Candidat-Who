<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Candidat.Who')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .form-control.search-input {
            background-color: rgba(255,255,255,0.1);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .form-control.search-input::placeholder {
            color: rgba(255,255,255,0.7);
        }
        .btn-search {
            border-color: rgba(255,255,255,0.3);
            color: white;
        }
        .btn-search:hover {
            background-color: rgba(255,255,255,0.2);
            color: white;
        }
        .search-form {
            position: fixed;
            top: 20px;     
            right: 20px;    
            z-index: 1000;  
            width: 250px;   
        }
    </style>
</head>
<body>

    @if(auth()->check())
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <!-- Logo + Title -->
            <div class="navbar-brand d-flex align-items-center">
                <img src="{{ asset('img/candidatwho.jpg') }}" alt="Logo" style="height: 40px;" class="me-2">
                <span>Candidat.Who?</span>
            </div>

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar items -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <!-- Home / Objectives Links -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ auth()->guard('admin')->check() ? route('admin.home') : (auth()->guard('web')->check() ? route('user.home') : url('/')) }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('objectives.show') }}">Objectives</a>
                    </li>

                    <!-- Officials Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Officials
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header text-secondary">Barangay Officials</li>
                            <li><a class="dropdown-item" href="{{ route('brgyofficials.index') }}">Current Officials</a></li>
                            <li><a class="dropdown-item" href="{{ route('runningofficials.index') }}">Running Officials</a></li>

                            <li><hr class="dropdown-divider"></li>

                            <li class="dropdown-header text-secondary">SK Officials</li>
                            <li><a class="dropdown-item" href="{{ route('currentsk.index') }}">Current SK Officials</a></li>
                            <li><a class="dropdown-item" href="{{ route('runningsk.index') }}">Running SK Officials</a></li>

                            @if(auth()->guard('admin')->check())
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-primary fw-bold" href="{{ route('admin.addofficials.create') }}">+ Add Official</a></li>
                            @endif
                        </ul>
                    </li>

                    <!-- Candidate Search (always visible) -->
                    <form class="d-flex mx-3" method="GET" action="{{ route('admin.candidates.index') }}">
                        <input class="form-control search-input me-2" type="search" name="query" placeholder="Search candidates" aria-label="Search">
                        <button class="btn btn-outline-light btn-search" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    <!-- Authentication Links -->
                    @if(auth()->guard('web')->check())
                        <li class="nav-item">
                            <span class="nav-link">Hello, {{ auth()->guard('web')->user()->name }}</span>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('user.logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm ms-2">Logout</button>
                            </form>
                        </li>
                    @elseif(auth()->guard('admin')->check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ auth()->guard('admin')->user()->profile_picture
                                        ? asset('storage/' . auth()->guard('admin')->user()->profile_picture)
                                        : asset('img/profile.png') }}"
                                     alt="Profile" class="me-2"
                                     style="border-radius: 50%; width: 30px; height: 30px; object-fit: cover;">
                                <span>{{ auth()->guard('admin')->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('admin.logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-danger fw-bold" href="{{ url('/user/login') }}">User Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger fw-bold" href="{{ url('/admin/login') }}">Admin Login</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @endif

    <!-- Page Content -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
