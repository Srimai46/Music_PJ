<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Music Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Sticky Footer */
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg"
        style="background: rgba(0,0,0,0.7); backdrop-filter: blur(8px); z-index: 1030;">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="{{ route('user.home') }}">
                Music Studio
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('user.home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#promotions">Promotions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('user.bookings') }}">My Bookings</a>
                    </li>
                    <!-- Dropdown username -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-3" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('user.profile.edit') }}">
                                <i class="bi bi-person-fill me-2"></i> Profile
                            </a></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                   <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mt-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="py-4 text-white text-center"
            style="background: rgba(0,0,0,0.7); backdrop-filter: blur(8px);">
        <div class="container">
            <h5 class="fw-bold mb-2">Music Studio</h5>
            <p class="mb-1">
                <i class="bi bi-geo-alt-fill me-1"></i>
                123/45 Main Street, Bangkok, Thailand
            </p>
            <p class="mb-1">
                <i class="bi bi-telephone-fill me-1"></i>
                +66 123 456 789
            </p>
            <p class="mb-2">
                <i class="bi bi-envelope-fill me-1"></i>
                info@musicstudio.com
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="#" class="text-white fs-5"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-white fs-5"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-white fs-5"><i class="bi bi-line"></i></a>
            </div>
            <small class="d-block mt-2 text-white-50">&copy; 2025 Music Studio. All rights reserved.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
