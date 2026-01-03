@extends('worker.layouts.app')
@section('title','Completed Tasks')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Completed Tasks</h3>

    @if($requests->count())
    <div class="table-container shadow-lg rounded-card shadow-sm">
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Client Email</th>
                    <th>Client Phone</th>
                    <th>Business</th>
                    <th>Service</th>
                    <th>Notes</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Deadline</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $req)
                <tr>
                    <td data-title="Client Name">{{ optional($req->client)->name ?? 'N/A' }}</td>
                    <td data-title="Client Email">{{ optional($req->client)->email ?? 'N/A' }}</td>
                    <td data-title="Client Phone">{{ optional($req->client)->phone ?? 'N/A' }}</td>
                    <td data-title="Business">{{ optional($req->business)->business_name ?? 'N/A' }}</td>
                    <td data-title="Service">{{ optional($req->service)->name ?? 'N/A' }}</td>
                    <td data-title="Notes">{{ $req->notes ?? '-' }}</td>
                    <td data-title="Status">
                        <span class="badge bg-success">Completed</span>
                    </td>
                    <td data-title="Date">{{ $req->date }}</td>
                    <td data-title="Time">{{ $req->time }}</td>
                    <td data-title="Deadline">
                        {{ $req->deadline ? \Carbon\Carbon::parse($req->deadline)->format('d-M-Y') : '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-muted">No completed tasks yet.</p>
    @endif
</div>
<div class="d-flex justify-content-center">
    {{ $requests->links('vendor.pagination.bootstrap-5') }}
</div>


<style>
.table-container {
    max-width: 100%;
    max-height: 550px;
    overflow-x: auto;
    overflow-y: auto;
    border-radius: 0.25rem;
    position: relative;
}

.table-container::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
.table-container::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2);
    border-radius: 3px;
}

.responsive-table {
    width: 145%;
    border-collapse: collapse;
}

.responsive-table th,
.responsive-table td {
    padding: 0.75em 0.5em;
    border: 1px solid rgba(134,188,37,1);
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
    background-color: rgba(0,0,0,.05);
}

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

.rounded-card {
    border-radius: 12px;
    box-shadow: 1px 2px 20px 20px rgba(0,0,0,0.07);
}
</style>
@endsection
