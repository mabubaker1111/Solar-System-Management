@extends('business.layout')

@section('title', 'Completed Requests')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-center">Completed Service Requests</h3>

    <div class="table-container">
        <table class="responsive-table">
            <thead>
                <tr>
                    <th scope="col">Client Name</th>
                    <th scope="col">Service</th>
                    <th scope="col">Worker</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $req)
                <tr>
                    <td data-title="Client Name">{{ $req->client->name ?? 'Unknown Client' }}</td>
                    <td data-title="Service">{{ $req->service->name ?? 'Unknown Service' }}</td>
                    <td data-title="Worker">{{ $req->worker->user->name ?? '-' }}</td>
                    <td data-title="Deadline">{{ $req->deadline ? \Carbon\Carbon::parse($req->deadline)->format('d-M-Y') : '-' }}</td>
                    <td data-title="Notes">{{ $req->notes ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No completed requests found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex justify-content-center">
        {{ $requests->links('vendor.pagination.bootstrap-5') }}
    </div>

<style>
/* Table Container */
.table-container {
    max-height: 550px;
    overflow-y: auto;
    overflow-x: auto;
    width: 100%;
    /* border: 1px solid rgba(134,188,37,0.3); */
    border-radius: 0.25rem;
    position: relative;
}

/* Scrollbar Styling */
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
    width: 100%;
    border-collapse: collapse;
    min-width: 700px; /* horizontal scroll if needed */
}

.responsive-table th,
.responsive-table td {
    padding:0.75em 0.5em;
    border: 1px solid rgba(134,188,37,0.8);
    text-align: center;
    vertical-align: middle;
}

/* Sticky Header */
.responsive-table thead th {
    background: linear-gradient( #4e73df, #1cc88a);
    color: white;
    position: sticky;
    top: 0;
    z-index: 2;
}

/* Zebra Striping */
.responsive-table tbody tr:nth-of-type(even) {
    background-color: rgba(0,0,0,.05);
}

/* Mobile View */
@media (max-width: 768px) {
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
