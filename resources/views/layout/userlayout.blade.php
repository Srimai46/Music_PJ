<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Music Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Minimal dropdown styling */
        .dropdown-menu {
            min-width: 180px; /* ลดขนาดกล่อง */
            border-radius: 0.25rem;
            box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,0.1);
            padding: 0.25rem 0;
        }
        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.95rem;
        }
        .dropdown-menu.mt-3 {
            margin-top: 1rem !important; /* เว้นช่องว่างด้านบน dropdown */
        }
        /* เพิ่ม effect hover แบบ minimal */
        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #212529;
        }
        .navbar-dark .navbar-nav .nav-link {
            font-weight: 500;
        }
    </style>
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('user.home') }}">Music Studio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('user.home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#promotions">Promotions</a></li>
                    <!-- Dropdown username -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-3" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('user.profile.edit') }}">Profile</a></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
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
    <div class="container mt-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
