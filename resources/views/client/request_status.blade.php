@extends('client.layout')
@section('title','My Requests')

@section('content')
<div class="container mt-4" style="height: auto">
    <h3 class="mb-4">My Service Requests</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(isset($requests) && $requests->count())
    <div class="table-container rounded-card shadow-xlg">
        <table class="responsive-table">
            <caption class="fs-6 fw-bold text-center">Services Requests</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th>Business</th>
                    <th>Worker</th>
                    <th>Status</th>
                    <th>Requested At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $index => $req)
                <tr>
                    <td data-title="#"> {{ $index + 1 }} </td>
                    <td data-title="Service">{{ $req->service->name ?? 'N/A' }}</td>
                    <td data-title="Business">{{ $req->business->business_name ?? 'N/A' }}</td>
                    <td data-title="Worker">
                        @if($req->worker && $req->worker->user)
                            <div><strong>{{ $req->worker->user->name }}</strong></div>
                            <div>Email: {{ $req->worker->user->email ?? '-' }}</div>
                            <div>Phone: {{ $req->worker->user->phone ?? '-' }}</div>

                            {{-- @if(\Illuminate\Support\Facades\Route::has('worker.profile'))
                                <a href="{{ route('worker.profile', $req->worker->id) }}"
                                   class="btn btn-sm btn-outline-primary mt-1">View Worker</a>
                            @endif --}}
                        @else
                            <span class="text-muted">Not assigned</span>
                        @endif
                    </td>
                    <td data-title="Status">
                        <span class="badge 
                            @if($req->status === 'pending') bg-warning
                            @elseif($req->status === 'approved') bg-success
                            @elseif($req->status === 'assigned') bg-info
                            @elseif($req->status === 'rejected') bg-danger
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($req->status) }}
                        </span>
                    </td>
                    <td data-title="Requested At">{{ \Carbon\Carbon::parse($req->created_at)->format('d M, Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p class="text-muted">You have not sent any requests yet.</p>
    @endif
</div>
<div class="d-flex justify-content-center">
        {{ $requests->links('vendor.pagination.bootstrap-5') }}
    </div>

<style>
/* Table Container with scroll */
.table-container {
    max-width: 100%;
    max-height: 800px;
    overflow-x: auto;
    overflow-y: auto;
    border-radius: 0.25rem;
    position: relative;
}

/* Scrollbar */
.table-container::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
.table-container::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2);
    border-radius: 3px;
}

/* Responsive Table */
.responsive-table {
    width: 120%;
    border-collapse: collapse;
}

.responsive-table th,
.responsive-table td {
    padding: 0.75em 0.5em;
    border: 1px solid rgba(134,188,37,1);
    text-align: center;
    vertical-align: middle;
}

/* Sticky Header */
.responsive-table thead th {
    background: linear-gradient(#4e73df, #1cc88a);
    color: white;
    position: sticky;
    top: 0;
    z-index: 2;
}

/* Zebra Striping */
.responsive-table tbody tr:nth-of-type(even) {
    background-color: rgba(0,0,0,.05);
}

/* Mobile view */
@media (max-width: 768px) {
    .responsive-table thead {
        position: absolute;
        clip: rect(1px 1px 1px 1px); 
        height: 1px; 
        width: 1px; 
        overflow: hidden;
    }

    .responsive-table tbody,
    .responsive-table tr,
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

/* Rounded card shadow */
.rounded-card {
    border-radius: 12px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.07);
}
</style>
@endsection
