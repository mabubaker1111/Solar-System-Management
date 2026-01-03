@extends('superadmin.layout')

@section('title', 'All Clients')

@section('content')
<h3 class="text-center fw-bold mb-4">All Clients</h3>
<div class="table-container boxshadow">
    <table class="responsive-table">
        <caption class="fs-6">All Registered Clients</caption>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Address</th>
                <th scope="col">Registered At</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr>
                <th scope="row">{{ $client->id }}</th>
                <td data-title="Name">{{ $client->name }}</td>
                <td data-title="Email">{{ $client->email }}</td>
                <td data-title="Phone">{{ $client->phone }}</td>
                <td data-title="Address">{{ $client->address }}</td>
                <td data-title="Registered At">{{ $client->created_at->format('d-M-Y') }}</td>
                <td data-title="Actions">
                    <form action="{{ route('superadmin.client.delete', $client->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure?')">
                            <i class="bi bi-trash text-light"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination links -->
<div class="d-flex justify-content-center">
    {{ $clients->links('vendor.pagination.bootstrap-5') }}
</div>



<style>


    .boxshadow {
    box-shadow: 1px 1px 10px -2px;
}
.table-container {
    width: calc(100%); 
    overflow-x: auto;
    max-height: 600px;
    padding: 0;
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

.responsive-table tbody tr:nth-of-type(even) {
    background-color: rgba(0,0,0,.05);
}

.responsive-table td form button {
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
</style>
@endsection
