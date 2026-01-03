@extends('business.layout')

@section('content')

<h2 class="mb-4">My Services</h2>

<div class="card p-4 mb-4">
    <h4>Add New Service</h4>

    <form action="{{ route('business.services.add') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Service Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description (optional)</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Add Service</button>
    </form>
</div>

    <h4 class="mb-3 text-center mt-4">Your Services</h4>
    @if($services->count())
    <div class="table-container shadow-lg">
        <table class="responsive-table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                <tr>
                    <td data-title="Name">{{ $service->name }}</td>
                    <td data-title="Price">{{ $service->price }}</td>
                    <td data-title="Description">{{ $service->description }}</td>
                    <td data-title="Action">
                        <div class="d-flex justify-content-center gap-1">
                            <form action="{{ route('business.services.delete', $service->id) }}" method="POST" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm bi bi-x-circle-fill"></button>
                            </form>
                            <a href="{{ route('business.services.edit', $service->id) }}" class="btn btn-warning text-light btn-sm bi bi-pencil"></a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p class="text-center text-muted">No services found</p>
    @endif
    <div class="d-flex justify-content-center">
        {{ $services->links('vendor.pagination.bootstrap-5') }}
    </div>
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
    min-width: 600px; 
}

.responsive-table th,
.responsive-table td {
    padding: 0.5em;
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
    width: 6px;
    height: 6px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2);
    border-radius: 3px;
}
</style>

</div>

@endsection