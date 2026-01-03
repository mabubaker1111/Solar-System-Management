<!-- resources/views/client/layout.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Panel - @yield('title')</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Fonts & CSS -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-pO5hGqv8v+J+J8hJf3kU1nJ6qF1I7v9Zr+9t7bT8m9CgLhUu5O3NkO6zZy1u9k0Hq4bV9j3j0N2H8fA1f0bYxw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <style>
        body {
            background: #f5f7fa;
            font-family: 'Nunito', sans-serif;
        }

        /* Navbar */
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

        /* Sidebar */
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

        .badge-unread {
            font-size: 0.75rem;
            background: #198754;
            color: white;
            border-radius: 10px;
            padding: 2px 6px;
            margin-left: 5px;
        }

        /* Content */
        .content {
            padding: 30px 20px;
        }

        /* Cards styling */
        .rounded-card {
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm px-4 py-2">
        <span class="navbar-brand text-light d-flex align-items-center">
            <i class="fas fa-solar-panel me-2"></i> Client Dashboard
        </span>

        <div class="ms-auto d-flex align-items-center">
            <!-- Logout -->
            <form action="{{ route('client.logout') }}" method="POST">
                @csrf
                <button class="btn btn-logout btn-sm fw-bold">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-3 sidebar rounded-3 shadow-sm">
                <h5>Client Panel</h5>

                <a href="{{ route('client.dashboard') }}" class="{{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>

                <h6 class="text-white-50 mt-4 mb-2">Business</h6>
                <a href="{{ route('client.businesses') }}" class="{{ request()->routeIs('client.businesses') ? 'active' : '' }}">
                    <i class="bi bi-building me-2"></i> Browse Businesses
                </a>

                <h6 class="text-white-50 mt-4 mb-2">Requests & Queries</h6>
                <a href="{{ route('client.requests') }}">
                    <i class="fas fa-handshake me-2"></i> My Requests
                    @isset($unreadReplies)
                        @if($unreadReplies > 0)
                            <span class="badge-unread">{{ $unreadReplies }}</span>
                        @endif
                    @endisset
                </a>

                <a href="{{ route('client.query.create', ['business_id' => 1]) }}">
                    <i class="fas fa-envelope me-2"></i> Contact Business
                </a>

                @if(isset($latestQuery) && $latestQuery)
                <a href="{{ route('client.query.show', $latestQuery->id) }}">
                    <i class="fas fa-reply me-2"></i> Latest Query Reply
                    @if($latestQuery->response)
                        <span class="badge bg-success ms-2">Replied</span>
                    @endif
                </a>
                @endif

                <h6 class="text-white-50 mt-4 mb-2">Notifications</h6>
                <a href="{{ route('client.notifications.index') }}" class="{{ request()->routeIs('client.notifications.index') ? 'active' : '' }}">
                    <i class="fas fa-bell me-2"></i> Notifications
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="badge-unread">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </a>

            </div>

            <!-- Main Content -->
            <div class="col-md-9 p-4 content">
                @yield('content')
            </div>

        </div>
    </div>

</body>

</html>
