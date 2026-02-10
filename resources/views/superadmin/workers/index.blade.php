@extends('superadmin.layout')

@section('title', 'All Workers')

@section('content')
<div class="container ">
   <h3 class="mb-4 text-center fw-bold">All Workers</h3>

<div class="table-container boxshadow">
    <table class="responsive-table">
        <caption class="fs-6">All Registered Workers</caption>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Address</th>
                <th scope="col">Status</th>
                <th scope="col">Registered At</th>
                {{-- <th scope="col">Actions</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach($workers as $worker)
            <tr>
                <th scope="row">{{ $worker->id }}</th>
                <td data-title="Name">{{ $worker->user->name }}</td>
                <td data-title="Email">{{ $worker->user->email }}</td>
                <td data-title="Phone">{{ $worker->user->phone }}</td>
                <td data-title="Address">{{ $worker->user->address }}</td>
                <td data-title="Status">{{ ucfirst($worker->status) }}</td>
                <td data-title="Registered At">{{ $worker->created_at->format('d-M-Y') }}</td>
                {{-- <td data-title="Actions">
                    @if($worker->status == 'pending')
                    <form action="{{ route('superadmin.worker.approve', $worker->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm bi bi-check-circle-fill"></button>
                    </form>

                    <form action="{{ route('superadmin.worker.reject', $worker->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm bi bi-x-circle-fill"></button>
                    </form>
                    @else
                    <span class="text-muted">No actions</span>
                    @endif
                </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div>
<div class="d-flex justify-content-center">
    {{ $workers->links('vendor.pagination.bootstrap-5') }}
</div>

<style>
    .boxshadow {
    box-shadow: 1px 1px 10px -2px;
}
/* Table Container Adjusted for Sidebar */
.table-container {
    width: calc(100%);
    overflow-x: auto;
    max-height: 550px;
    padding: 0;
}

/* Scrollbar Styling */
.table-container::-webkit-scrollbar {
    height: 6px;
}
.table-container::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.2);
    border-radius: 3px;
}

/* Responsive Table */
.responsive-table {
    width: 120%;
    border-collapse: collapse;
    /* margin-bottom: 1.5em; */
    font-family: sans-serif;
}

.responsive-table caption {
    font-size: 1.2em;
    font-weight: bold;
    margin-bottom: 0.5em;
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
}

/* Zebra Striping */
.responsive-table tbody tr:nth-of-type(even) {
    background-color: rgba(0,0,0,.05);
}

/* Actions Button Styling */
.responsive-table td form button,
.responsive-table td span {
    display: inline-block;
    margin: 0;
}

/* Mobile View */
@media (max-width: 768px) {
    .table-container {
        width: 100%;
        margin-left: 0;
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