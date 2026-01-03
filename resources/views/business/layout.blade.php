<!-- resources/views/business/layout.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Panel - @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-pO5hGqv8v+J+J8hJf3kU1nJ6qF1I7v9Zr+9t7bT8m9CgLhUu5O3NkO6zZy1u9k0Hq4bV9j3j0N2H8fA1f0bYxw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            background: #f5f7fa;
            font-family: 'Nunito', sans-serif;
        }

        .navbar-custom {
            background: linear-gradient(90deg, #4e73df, #1cc88a);
            color: white;
        }

        .navbar-custom .navbar-brand {
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
            height: 100wh;
            background: linear-gradient(180deg, #4e73df, #1cc88a);
            color: white;
            border-right: 1px solid #ddd;
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
            transition: all 0.3s;
            text-decoration: none;
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

        .badge-custom {
            position: absolute;
            top: 0;
            right: 0;
            font-size: 0.7rem;
        }

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
        <span class="navbar-brand d-flex text-light align-items-center">
            <i class="fas fa-solar-panel me-2"></i> Business Dashboard
        </span>

        <div class="ms-auto d-flex align-items-center">
            <form action="{{ route('business.logout') }}" method="POST">
                @csrf
                <button class="btn btn-logout btn-sm fw-bold">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-3 sidebar rounded-3 shadow-sm">
                <h5>Business Panel</h5>

                <a href="{{ route('business.dashboard') }}"
                    class="{{ request()->routeIs('business.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>

                <h6 class="text-white-50 mt-4 mb-2">Requests</h6>
                <a href="{{ route('business.client.requests') }}"
                    class="{{ request()->routeIs('business.client.requests') ? 'active' : '' }}">
                    <i class="fas fa-handshake me-2"></i> Client Requests
                </a>
                <a href="{{ route('business.workers.requests') }}"
                    class="{{ request()->routeIs('business.workers.requests') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i> Workers
                </a>
                @if(Route::has('business.assigned.requests'))
                <a href="{{ route('business.assigned.requests') }}"
                    class="{{ request()->routeIs('business.assigned.requests') ? 'active' : '' }}">
                    <i class="fas fa-tasks me-2"></i> Assigned Requests
                </a>
                @endif

                <h6 class="text-white-50 mt-4 mb-2">Services & Queries</h6>
                <a href="{{ route('business.services') }}"
                    class="{{ request()->routeIs('business.services') ? 'active' : '' }}">
                    <i class="fas fa-concierge-bell me-2"></i> Services
                </a>
                <a href="{{ route('business.query.index') }}"
                    class="{{ request()->routeIs('business.query.index') ? 'active' : '' }}">
                    <i class="fas fa-envelope me-2"></i> Client Queries
                </a>


                <h6 class="text-white-50 mt-4 mb-2">Completed Task</h6>
                <a href="{{ route('business.completed.requests') }}"
                    class="{{ request()->routeIs('business.completed_requests') ? 'active' : '' }}">
                    <i class="fas fa-envelope me-2"></i> Complete
                </a>

                <h6 class="text-white-50 mt-4 mb-2">Woker Details</h6>
                <a href="{{  route('business.workers') }}"
                    class="{{ request()->routeIs('business.workers') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i> My Wokers
                </a>


                <h6 class="text-white-50 mt-4 mb-2">Clients</h6>
                <a href="{{ route('business.clients.add') }}"
                    class="{{ request()->routeIs('business.clients.add') ? 'active' : '' }}">
                    <i class="fas fa-user-plus me-2"></i> Add Client
                </a>

                <h6 class="text-white-50 mt-4 mb-2">Payment Status</h6>
                <a href="{{ route('business.payments.index') }}"
                    class="{{ request()->routeIs('business.payments.index') ? 'active' : '' }}">
                    <i class="fas fa-dollar-sign me-2"></i> Payment Details
                </a>
                <h6 class="text-white-50 mt-4 mb-2">Worker Shifts</h6>
                <a href="{{ route('business.workers.shifts') }}"
                    class="{{ request()->routeIs('business.workers.shifts') ? 'active' : '' }}">
                    <i class="fas fa-clock me-2"></i> Worker Shifts
                </a>


                {{-- <li class="nav-item">
                    <a href="{{ route('business.payments.index') }}" class="nav-link">
                        <i class="fas fa-dollar-sign"></i>
                    </a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('business.workers') }}">
                        <i class="fas fa-users"></i> My Workers
                    </a>
                </li> --}}


                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('business.completed.requests') }}">
                        <i class="fas fa-check-circle"></i> Completed Requests
                    </a>
                </li> --}}

                <h6 class="text-white-50 mt-4 mb-2">Notifications</h6>
                <a href="{{ route('business.notifications.index') }}"
                    class="{{ request()->routeIs('business.notifications.index') ? 'active' : '' }}">
                    <i class="fas fa-bell me-2"></i> Notifications
                    @if(isset($unreadCount) && $unreadCount > 0)
                    <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                    @endif
                </a>

            </div>

            <div class="col-md-9 p-4">
                @yield('content')
            </div>

        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>