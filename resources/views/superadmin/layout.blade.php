<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - @yield('title')</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-pO5hGqv8v+J+J8hJf3kU1nJ6qF1I7v9Zr+9t7bT8m9CgLhUu5O3NkO6zZy1u9k0Hq4bV9j3j0N2H8fA1f0bYxw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-pO5hGqv8v+J+J8hJf3kU1nJ6qF1I7v9Zr+9t7bT8m9CgLhUu5O3NkO6zZy1u9k0Hq4bV9j3j0N2H8fA1f0bYxw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            background: #f5f7fa;
        }

        .navbar-brand {
            font-weight: 600;
        }

        .sidebar {
            height: 100wh;
            background: white;
            border-right: 1px solid #ddd;
            padding: 20px 15px;
        }

        .sidebar a {
            display: block;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 6px;
            color: #333;
            font-weight: 500;
        }

        .sidebar a:hover,
        .sidebar .active {
            background: #0d6efd;
            color: rgb(212, 209, 209) !important;
        }

        .notification-bell {
            position: relative;
            cursor: pointer;
        }

        .notification-bell .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 0.7rem;
        }

        .dropdown-menu-notifications {
            max-height: 300px;
            overflow-y: auto;
            width: 300px;
        }
    </style>
</head>

<body id="page-top">

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm px-4 py-2"
        style="background: linear-gradient(90deg, #4e73df, #1cc88a); color: white;">
        <span class="navbar-brand text-light d-flex align-items-center">
            <i class="fas fa-solar-panel"></i>&nbsp;Super Admin Dashboard
        </span>

        <div class="ms-auto d-flex align-items-center">
            <form action="{{ route('superadmin.logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-light btn-sm fw-bold">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-3 sidebar m rounded-3 shadow-sm"
                style="background: linear-gradient(180deg, #4e73df, #1cc88a); color: white;">
                <h5 class="fw-bold mb-4 text-center">Super Admin Panel</h5>

                <!-- Dashboard -->
                <a href="{{ route('superadmin.dashboard') }}"
                    class="d-block py-2 px-3 mb-2 rounded {{ request()->routeIs('superadmin.dashboard') ? 'bg-white text-primary fw-bold' : 'text-white' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>

                <!-- Users -->
                <h6 class="text-white-50 mt-4 mb-2">Users</h6>
                <a href="{{ route('superadmin.clients') }}"
                    class="d-block py-2 px-3 mb-1 rounded {{ request()->routeIs('superadmin.clients') ? 'bg-white text-primary fw-bold' : 'text-white' }}">
                    <i class="bi bi-people me-2"></i> All Clients
                </a>

                <!-- Businesses -->
                <h6 class="text-white-50 mt-4 mb-2">Businesses</h6>
                <a href="{{ route('superadmin.businesses') }}"
                    class="d-block py-2 px-3 mb-1 rounded {{ request()->routeIs('superadmin.businesses') ? 'bg-white text-primary fw-bold' : 'text-white' }}">
                    <i class="bi bi-building me-2"></i> All Businesses
                </a>

                <!-- Workers -->
                <h6 class="text-white-50 mt-4 mb-2">Workers</h6>
                <a href="{{ route('superadmin.workers') }}"
                    class="d-block py-2 px-3 mb-1 rounded {{ request()->routeIs('superadmin.workers') ? 'bg-white text-primary fw-bold' : 'text-white' }}">
                    <i class="bi bi-person-workspace me-2"></i> All Workers
                </a>
                {{-- <a href="{{ route('superadmin.requests.worker') }}" 
                    class="d-block py-2 px-3 mb-1 rounded {{ request()->routeIs('superadmin.requests.worker') ? 'bg-white text-primary fw-bold': 'text-white'}}">
                    <i class="bi bi-hourglass-split me-2"></i> Worker Requests
                </a> --}}

                <!-- Requests -->
                <h6 class="text-white-50 mt-4 mb-2">Requests</h6>
                <a href="{{ route('superadmin.requests.client') }}" 
                class="d-block py-2 px-3 mb-1 rounded {{ request()->routeIs('superadmin.requests.client') ? 'bg-white text-primary fw-bold': 'text-white'}}">
                    <i class="bi bi-journal-text me-2"></i> Client Requests
                </a>

                {{-- complete --}}
                <h6 class="text-white-50 mt-4 mb-2">Completed</h6>
                <a href="{{ route('superadmin.requests.completed') }}"
                    class="d-block py-2 px-3 mb-1 rounded {{ request()->routeIs('superadmin.requests.completed') ? 'bg-white text-primary fw-bold': 'text-white'}}">
                    <i class="bi bi-journal-text me-2"></i> Completed Works
                </a>

                {{-- <li>
                    <a href="{{ route('superadmin.requests.completed') }}" class="text-primary">
                        Completed Requests
                    </a>
                </li> --}}
                <!-- Notifications -->
                <h6 class="text-white-50 mt-4 mb-2">Notifications</h6>
                <a href="{{ route('superadmin.notifications') }}"
                    class="d-block py-2 px-3 mb-1 rounded {{ request()->routeIs('superadmin.notifications') ? 'bg-white text-primary fw-bold' : 'text-white' }}">
                    <i class="bi bi-bell me-2"></i> Notifications
                    @if(isset($notifications) && $notifications->where('read_at', null)->count() > 0)
                    <span class="badge bg-danger ms-2">{{ $notifications->where('read_at', null)->count() }}</span>
                    @endif
                </a>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 p-4">
                @yield('content')
            </div>

        </div>
    </div>

    <!-- Scripts (CDN) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Scripts (Bottom of Body) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('scripts')
    <!-- Blade section for page-specific JS -->

</body>

</html>