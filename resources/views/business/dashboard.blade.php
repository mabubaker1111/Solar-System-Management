@extends('business.layout')

@section('content')

@if(auth()->check() && auth()->user()->role === 'business')
<h3 class="text-center fw-bold">Welcome, {{ $business->business_name }}</h3>
@else
<h3>Business not logged in</h3>
@endif

<div class="row mt-4">
    <div class="col-md-4 mb-3">
        <div class="card card-hover border border-3 border-primary   shadow text-center">
            <div class="card-body">
                <h5 class="fw-bold">Total Clients
                                    <i class='fas fa-user-friends text-primary'></i>
                </h5>
                <h2>{{ $totalRequests }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card card-hover border border-3 border-warning shadow text-center">
            <div class="card-body">
                <h5 class="fw-bold">Pending Requests
                    <i class="fas fa-alarm-clock text-primary"></i>
                </h5>
                <h2>{{ $pending }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card card-hover border border-3 border-success shadow text-center">
            <div class="card-body">
                <h5 class="fw-bold">Available Slots</h5>
                <h2>{{ $slots }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body text-center">
        <h5 class="card-title">Services</h5>
        <p class="text-muted">Add, update and manage your services</p>
        <a href="{{ route('business.services') }}" class="btn btn-primary">Manage Services</a>
    </div>
</div>


<h3 class="card-title mt-5 text-center">Latest Client Requests</h3>
<div class="card-body">

    @if($latestRequests->count())
    <div class="table-container shadow-lg">
        <table class="responsive-table">
            <thead>
                <tr>
                    <th scope="col">Client</th>
                    <th scope="col">Service</th>
                    <th scope="col">Worker</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($latestRequests as $req)
                <tr>
                    <td data-title="Client">{{ $req->client->name ?? 'N/A' }}</td>
                    <td data-title="Service">{{ $req->service->name ?? 'N/A' }}</td>
                    <td data-title="Worker">
                        @if($req->status == 'pending')
                        Pending
                        @elseif($req->status == 'approved')
                        Approved
                        @elseif($req->status == 'assigned')
                        Assigned to {{ $req->worker->user->name ?? 'N/A' }}
                        @elseif($req->status == 'rejected')
                        Rejected
                        @elseif($req->status == 'completed')
                        Completed
                        @endif
                    </td>
                    <td data-title="Status">
                        <span class="badge 
                                @if($req->status === 'pending') bg-warning
                                @elseif($req->status === 'approved') bg-success
                                @elseif($req->status === 'rejected') bg-danger
                                @elseif($req->status === 'assigned') bg-info
                                @else bg-secondary
                                @endif">
                            {{ ucfirst($req->status) }}
                        </span>
                    </td>
                    <td data-title="Action">
                        @if($req->status === 'pending')
                        <form action="{{ route('business.request.accept', $req->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success bi bi-check-circle-fill"></button>
                        </form>

                        <form action="{{ route('business.request.reject', $req->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger bi bi-x-circle-fill"></button>
                        </form>
                        @elseif($req->status === 'approved')
                        <span class="text-muted">Approved</span>
                        @elseif($req->status === 'rejected')
                        <span class="text-muted">Rejected</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination links -->
    <div class="d-flex justify-content-center">
        {{ $latestRequests->links('vendor.pagination.bootstrap-5') }}
    </div>
    @else
    <p class="text-muted text-center">No requests available.</p>
    @endif
</div>
</div>

@if(session('success'))
<div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger mt-3">{{ session('error') }}</div>
@endif


<style>

    .card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; background: linear-gradient(145deg,#fff,#f0f3f8);}
.card-hover:hover { transform: translateY(-6px) scale(1.03); box-shadow:2px 2px 8px 20px rgba(0,0,0,0.15);}
.icon-hover { transition: transform 0.3s ease, color 0.3s ease;}
.card-hover:hover .icon-hover { transform: rotate(15deg) scale(1.2); color:#0d6efd;}
.card-hover h6 { letter-spacing:0.5px; font-weight:500;}
.card-hover h3 { font-weight:700;}
    .table-container {
        width: 100%;
        max-height: 550px;
        overflow-y: auto;
        overflow-x: auto;
        border-radius: 0.25rem;
        position: relative;
    }

    .table-container::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    .table-container::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 3px;
    }

    .responsive-table {
        width: 100%;
        border-collapse: collapse;
        font-family: sans-serif;
    }

    .responsive-table th,
    .responsive-table td {
        padding: 0.75em 0.5em;
        border: 1px solid rgba(134, 188, 37, 1);
        text-align: center;
        vertical-align: middle;
    }

    .responsive-table thead th {
        background: linear-gradient(#4e73df, #1cc88a);
        color: white;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    .responsive-table tbody tr:nth-of-type(even) {
        background-color: rgba(0, 0, 0, .05);
    }

    @media (max-width: 768px) {
        .table-container {
            width: 100%;
        }

        .responsive-table thead {
            position: absolute;
            clip: rect(1px 1px 1px 1px);
            padding: 0;
            border: 0;
            height: 1px;
            width: 1px;
            overflow: hidden;
        }

        .responsive-table tbody,
        .responsive-table tr,
        .responsive-table th,
        .responsive-table td {
            display: block;
            width: 100%;
            text-align: left;
        }

        .responsive-table td[data-title]:before {
            content: attr(data-title);
            font-weight: bold;
            float: left;
        }

        .responsive-table td {
            padding-left: 50%;
            position: relative;
        }

        .responsive-table td[data-title]:before {
            position: absolute;
            left: 0;
            top: 0;
            padding-left: 0.5em;
        }
    }
</style>
@endsection