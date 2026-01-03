@extends('superadmin.layout')

@section('title', 'Client Requests')

@section('content')
    <h3 class="text-center fw-bold mb-4">Clients Requests</h3>

<div class="table-container boxshadow">
    <table class="responsive-table">
        <caption class="fs-6">Client Service Requests</caption>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Client Name</th>
                <th scope="col">Service</th>
                <th scope="col">Business</th>
                <th scope="col">Worker</th>
                <th scope="col">Status</th>
                <th scope="col">Requested At</th>
                <th scope="col">Deadline</th>
                <th scope="col">Mark Completed</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
            <tr>
                <th scope="row">{{ $request->id }}</th>
                <td data-title="Client Name">{{ $request->client->name }}</td>
                <td data-title="Service">{{ $request->service?->name ?? '-' }}</td>
                <td data-title="Business">{{ $request->business?->business_name ?? '-' }}</td>
                <td data-title="Worker">{{ $request->worker?->user?->name ?? '-' }}</td>
                <td data-title="Status">{{ ucfirst($request->status) }}</td>
                <td data-title="Requested At">{{ $request->created_at?->format('d-M-Y') ?? '-' }}</td>
                <td data-title="Deadline">
                    @if($request->deadline)
                        @php
                            $today = \Carbon\Carbon::today();
                            $deadline = \Carbon\Carbon::parse($request->deadline);
                        @endphp
                        <span class="@if($deadline->isPast()) text-danger @elseif($deadline->diffInDays($today) <= 2) text-warning @endif">
                            {{ $deadline->format('d-M-Y') }}
                        </span>
                    @else
                        -
                    @endif
                </td>
                <td data-title="Mark Completed">
                    @if($request->status != 'completed')
                        <form method="POST" action="{{ route('superadmin.request.complete', $request->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Complete</button>
                        </form>
                    @else
                        <span class="text-success">Completed</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $requests->links('vendor.pagination.bootstrap-5') }}
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
    width: 130%;
    border-collapse: collapse;
    font-family: sans-serif;
}

.responsive-table caption {
    font-size: 1.2em;
    font-weight: bold;
    text-align: center;
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

.responsive-table td form button,
.responsive-table td span {
    display: inline-block;
    margin: 0;
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