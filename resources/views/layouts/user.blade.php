<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Panel - Candidat.Who?')</title>
    <meta name="description" content="User Panel for Candidat.Who? - Election Management System">
    <meta name="keywords" content="user, election, candidates, officials, barangay">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #333;
        }

        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Header styles */
        .header {
            background-color: rgba(255, 255, 255, 0.95) !important;
            color: #333 !important;
            z-index: 1030 !important;
        }
        .header .sitename {
            color: #333 !important;
        }
        .header a {
            color: #333 !important;
        }
        .header a:hover {
            color: #667eea !important;
        }

        /* Gradient buttons for consistency */
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
    </style>
</head>
<body class="user-page">

    <header id="header" class="header d-flex align-items-center">
        <div class="container position-relative d-flex align-items-center justify-content-between">

            <a href="{{ route('user.home') }}" class="logo d-flex align-items-center me-auto me-xl-0">
                <img src="{{ asset('img/candidatwho.jpg') }}" alt="Logo" style="height: 40px;" class="me-2">
                <h1 class="sitename">Candidat.Who?</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ route('user.home') }}" class="{{ request()->routeIs('user.home') ? 'active' : '' }}"><i class="bi bi-house me-1"></i>Dashboard</a></li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">
                            <span><i class="bi bi-people me-1"></i>Officials</span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            <li><a href="{{ route('brgyofficials.index') }}"><i class="bi bi-person-badge me-2"></i>Barangay Officials</a></li>
                            <li><a href="{{ route('runningofficials.index') }}"><i class="bi bi-person-plus me-2"></i>Running Officials</a></li>
                            <li><a href="{{ route('currentsk.index') }}"><i class="bi bi-people-fill me-2"></i>Current SK Officials</a></li>
                            <li><a href="{{ route('runningsk.index') }}"><i class="bi bi-people me-2"></i>Running SK Officials</a></li>
                        </ul>
                    </li>

                    <li><a href="{{ route('objectives.show') }}" class="{{ request()->routeIs('objectives.show') ? 'active' : '' }}"><i class="bi bi-bullseye me-1"></i>Objectives</a></li>
                    <li><a href="{{ route('search') }}" class="{{ request()->routeIs('search') ? 'active' : '' }}"><i class="bi bi-search me-1"></i>Search</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <div class="dropdown">
                <a href="#" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                    <img src="{{ auth('web')->user()->profile_picture
                            ? asset('storage/' . auth('web')->user()->profile_picture)
                            : 'data:image/svg+xml;base64,' . base64_encode('<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="15" cy="15" r="15" fill="#6c757d"/><circle cx="15" cy="12" r="5" fill="#ffffff"/><path d="M6 25c0-5.5 4.5-10 10-10s10 4.5 10 10" fill="#ffffff"/></svg>') }}"
                         alt="Profile" class="me-2 rounded-circle"
                         style="width: 30px; height: 30px; object-fit: cover;">
                    <span>{{ auth('web')->user()->name ?? 'User' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('user.profile.edit') }}">
                        <i class="bi bi-person-gear me-2"></i>Edit Profile
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('user.logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="dropdown-item" style="border: none; background: none; padding: 0; width: 100%; text-align: left;">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>
    </header>

    <main class="main">

        {{-- Main Content --}}
        <div class="content-wrapper container-fluid my-4">
            @yield('content')
        </div>

    </main>

    <footer id="footer" class="footer dark-background mt-auto py-3">
        <div class="container text-center">
            <small class="d-block fw-bold">Candidat.Who? – User Panel</small>
            <small class="d-block mb-1">Election Management System for Barangay Bonuan Binloc</small>
            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2">
                <small>&copy; {{ date('Y') }} Candidat.Who? All Rights Reserved</small>
                <small class="text-muted">|</small>
                <small>Designed by <a href="https://bootstrapmade.com/" target="_blank" class="text-decoration-none">BootstrapMade</a></small>
            </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        // Initialize AOS
        AOS.init();
    </script>
</body>
</html>
