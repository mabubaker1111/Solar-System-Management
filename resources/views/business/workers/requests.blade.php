@extends('business.layout')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4 text-center">Pending Worker Requests</h3>

    @if($workers->count() > 0)
    <div class="table-container">
        <table class="responsive-table">
            <caption class="fs-6 text-center fw-bold"></caption>
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Skill</th>
                    <th scope="col">Experience</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($workers as $worker)
                <tr>
                    <td data-title="Name">{{ $worker->user->name }}</td>
                    <td data-title="Email">{{ $worker->user->email }}</td>
                    <td data-title="Skill">{{ $worker->skill }}</td>
                    <td data-title="Experience">{{ $worker->experience }}</td>
                    <td data-title="Actions">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('business.workers.approve', $worker->id) }}" class="btn btn-success btn-sm">Approve</a>
                            <a href="{{ route('business.workers.reject', $worker->id) }}" class="btn btn-danger btn-sm">Reject</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @else
        <p class="text-center text-muted">No pending worker requests.</p>
    @endif
</div>
<div class="d-flex justify-content-center">
        {{ $workers->links('vendor.pagination.bootstrap-5') }}
</div>

<style>
.table-container {
    max-height: 550px;
    overflow-y: auto;
    overflow-x: auto;
    width: 100%;
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
    width: 100%;
    border-collapse: collapse;
    min-width: 800px; 
}

.responsive-table th,
.responsive-table td {
    padding: 0.75em 0.5em;
    border: 1px solid rgba(134,188,37,0.8);
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
        max-height: 400px;
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
