<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        /* Minimal dropdown styling */
        .dropdown-menu {
            min-width: 180px;
            /* ลดขนาดกล่อง */
            border-radius: 0.25rem;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
            padding: 0.25rem 0;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.95rem;
        }

        .dropdown-menu.mt-3 {
            margin-top: 1rem !important;
            /* เว้นช่องว่างด้านบน dropdown */
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #212529;
        }

        .navbar-dark .navbar-nav .nav-link {
            font-weight: 500;
        }

        .modal-backdrop.show {
            backdrop-filter: blur(20px); /* ระดับความเบลอ */
            background-color: rgba(0, 0, 0, 0.4); /* เพิ่มความมืดนิดหน่อย */
        }
    </style>
    @stack('styles')
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Music Studio Admin</a>
            <div class="ms-auto">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-3" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}">Profile</a></li>
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
        </div>
    </nav>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>

    <!-- Main Container -->
    <div class="container mt-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 mb-3">
                <div class="list-group">
                    <a href="{{ route('admin.dashboard') }}"
                        class="list-group-item list-group-item-action">Dashboard</a>
                    <a href="{{ route('admin.userManagement') }}"
                        class="list-group-item list-group-item-action">Users</a>
                    <a href="{{ route('admin.rooms') }}" class="list-group-item list-group-item-action">Rooms</a>
                    <a href="{{ route('admin.promotions') }}"
                        class="list-group-item list-group-item-action">Promotions</a>
                    <a href="{{ route('admin.instrumentCategories') }}" class="list-group-item list-group-item-action">Musical
                        Instrument</a>
                    <a href="{{ route('admin.log') }}" class="list-group-item list-group-item-action">Log</a>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-md-9">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>

</html>
