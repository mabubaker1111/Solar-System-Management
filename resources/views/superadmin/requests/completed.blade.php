@extends('superadmin.layout')

@section('title','Completed Client Requests')

@section('content')

    <h3 class="text-center fw-bold mb-4">All Completed Client Requests</h3>

<div class="table-container boxshadow">

    <table class="responsive-table  mb-2">
                <caption class="fs-6 text-center fw-bold">Completed Client Service Requests</caption>
        <thead>
            <tr>
                <th scope="col">Client Name</th>
                <th scope="col">Business</th>
                <th scope="col">Service</th>
                <th scope="col">Worker</th>
                <th scope="col">Notes</th>
                <th scope="col">Deadline</th>
            </tr>
        </thead>
        <tbody>
            @forelse($completedRequests as $req)
            <tr>
                <td data-title="Client Name">{{ $req->client->name ?? 'Unknown Client' }}</td>
                <td data-title="Business">{{ $req->business->business_name ?? 'Unknown Business' }}</td>
                <td data-title="Service">{{ $req->service->name ?? '-' }}</td>
                <td data-title="Worker">{{ $req->worker->user->name ?? '-' }}</td>
                <td data-title="Notes">{{ $req->notes ?? '-' }}</td>
                <td data-title="Deadline">{{ $req->deadline ? \Carbon\Carbon::parse($req->deadline)->format('d-M-Y') : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No completed requests found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $completedRequests->links('vendor.pagination.bootstrap-5') }}
</div>


<style>
    .boxshadow {
    box-shadow: 1px 1px 10px -2px;
}
.table-container {
    width: 100%;
    max-height: 550px; 
    overflow-y: auto;
    overflow-x: auto; 
    padding:  0;
    border-radius: 0.25rem;
    position: relative;
}

.table-container::-webkit-scrollbar {
    width: 6px;
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
    border: 1px solid rgba(134,188,37,1);
    text-align: center;
    vertical-align: middle;
}

.responsive-table thead th {
    background: linear-gradient( #4e73df, #1cc88a);
    color: white;
    position: sticky;
    top: 0;
    z-index: 2;
}

.responsive-table tbody tr:nth-of-type(even) {
    background-color: rgba(0,0,0,.05);
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
