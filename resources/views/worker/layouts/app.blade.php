<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Panel - @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-pO5hGqv8v+J+J8hJf3kU1nJ6qF1I7v9Zr+9t7bT8m9CgLhUu5O3NkO6zZy1u9k0Hq4bV9j3j0N2H8fA1f0bYxw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <style>
        body {
            background: #f5f7fa;
            font-family: 'Nunito', sans-serif;
        }

        .navbar-custom {
            background: linear-gradient(90deg, #4e73df, #1cc88a);
            color: white;
        }

        .navbar-brand {
            font-weight: 600;
        }

        .btn-logout {
            border: 1px solid white;
            color: white;
            font-weight: 600;
        }

        .btn-logout:hover {
            background: white;
            color: #1cc88a;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #4e73df, #1cc88a);
            color: white;
            padding: 20px 15px;
        }

        .sidebar h5 {
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 6px;
            color: white;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #fff;
            color: #1cc88a !important;
            font-weight: 600;
        }

        .sidebar a i {
            width: 20px;
            text-align: center;
        }

        .notification-badge {
            font-size: 0.75rem;
        }

        /* Main content */
        .content {
            padding: 30px 20px;
        }

        .rounded-card {
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm px-4 py-2">
        <span class="navbar-brand text-light d-flex align-items-center">
            <i class="fa fa-solar-panel me-2"></i>
            Worker Dashboard
        </span>

        <div class="ms-auto d-flex align-items-center">
            <form action="{{ route('worker.logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-logout btn-sm fw-bold"><i class="fas fa-sign-out-alt me-1"></i> Logout</button>
            </form>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-3 sidebar rounded-3 shadow-sm">
                <h5>Worker Panel</h5>

                <h6 class="text-white-50 mt-4 mb-2">Dashboard</h6>
                <a href="{{ route('worker.dashboard') }}"
                    class="{{ request()->routeIs('worker.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>


                <h6 class="text-white-50 mt-4 mb-2">Notifications</h6>

                <a href="{{ route('worker.notifications') }}"
                    class="{{ request()->routeIs('worker.notifications') ? 'active' : '' }}">
                    <i class="fas fa-bell me-2"></i> Notifications
                    @if(isset($notifications) && $notifications->where('read_at', null)->count() > 0)
                    <span class="badge bg-danger ms-2 notification-badge">{{ $notifications->where('read_at',
                        null)->count() }}</span>
                    @endif
                </a>

                <h6 class="text-white-50 mt-4 mb-2">Requests</h6>

                <a href="{{ route('worker.my_requests') }}"
                    class="{{ request()->routeIs('worker.my_requests') ? 'active' : '' }}">
                    <i class="bi bi-list-check me-2"></i> My Requests
                </a>

                <h6 class="text-white-50 mt-4 mb-2">Completed Work</h6>
                <a class="nav-link" href="{{ route('worker.completed.requests') }}">
                    <i class="fas fa-check-circle"></i> Completed Requests
                </a>

                <h6 class="text-white-50 mt-4 mb-2">Payment Details</h6>
                
                  <a class="nav-link" href="{{ route('worker.payments.index') }}">
                    <i class="fas fa-money-bill"></i> Paymnet Details
                </a>


                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('worker.completed.requests') }}">
                        <i class="fas fa-check-circle"></i> Completed Tasks
                    </a>
                </li> --}}

            </div>

            <div class="col-md-9 content">
                @if(session('success'))
                <div class="alert alert-success rounded-card">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger rounded-card">{{ session('error') }}</div>
                @endif

                @yield('content')
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>