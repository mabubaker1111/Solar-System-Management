@extends('superadmin.layout')
@section('title', 'All Businesses')
@section('content')

<h3 class="mb-4 text-center fw-bold">All Businesses</h3>
<div class="table-container boxshadow">
    <table class="responsive-table">
        <caption class="fs-6">All Registered Businesses</caption>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Business Name</th>
                <th scope="col">Owner</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($businesses as $b)
            <tr>
                <th scope="row">{{ $b->id }}</th>
                <td data-title="Business Name">{{ $b->business_name }}</td>
                <td data-title="Owner">{{ $b->owner->name ?? $b->business_Owner }}</td>
                <td data-title="Status">{{ ucfirst($b->status) }}</td>
                <td data-title="Actions">
                    <a href="{{ route('superadmin.business.view', $b->id) }}" class="btn btn-sm btn-primary mb-1" title="View Details">
                        <i class="bi bi-eye"></i>
                    </a>
                    @if($b->status == 'pending')
                    <form action="{{ route('superadmin.business.approve', $b->id) }}" method="POST" style="display:inline">
                        @csrf
                        <button class="btn btn-sm btn-success mb-1 bi bi-check-circle-fill"></button>
                    </form>

                    <form action="{{ route('superadmin.business.reject', $b->id) }}" method="POST" style="display:inline">
                        @csrf
                        <button class="btn btn-sm btn-warning text-light mb-1 bi bi-x-circle-fill"></button>
                    </form>
                    @endif

                    <form action="{{ route('superadmin.business.delete', $b->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger bi bi-trash mb-1"></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $businesses->links('vendor.pagination.bootstrap-5') }}
</div>

<style>
    .boxshadow {
    box-shadow: 1px 1px 10px -2px;
}
.table-container {
    width: calc(100%);
    overflow-x: auto;
    max-height: 570px;
    padding:0;
}

.table-container::-webkit-scrollbar {
    height: 6px;
}
.table-container::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.2);
    border-radius: 3px;
}

.responsive-table {
    width: 100%;
    border-collapse: collapse;
    /* margin-bottom: 1.5em; */
    font-family: sans-serif;
}

.responsive-table caption {
    font-size: 1.2em;
    font-weight: bold;
    /* margin-bottom: 35em; */
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

.responsive-table tbody tr:nth-of-type(even) {
    background-color: rgba(0,0,0,.05);
}

.responsive-table td form button,
.responsive-table td a {
    display: inline-block;
    margin: 0;
}

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




    .table-responsive::-webkit-scrollbar {
        width: 8px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background-color: rgba(0, 0, 0, 0.05);
    }
</style>

@endsection