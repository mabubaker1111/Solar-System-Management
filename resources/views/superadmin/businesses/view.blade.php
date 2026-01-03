@extends('superadmin.layout')

@section('title', 'Business Details')

@section('content')
<div class="container mt-4">
    <h3>Business Details: {{ $business->business_name }}</h3>

    <div class="mb-3 text-center">
        @if($business->image && file_exists(storage_path('app/public/'.$business->image)))
            <img src="{{ asset('storage/' . $business->image) }}" alt="Business Image" class="img-fluid rounded" style="max-height: 200px;">
        @else
            <img src="https://via.placeholder.com/200x150?text=No+Image" alt="No Image" class="img-fluid rounded">
        @endif
    </div>

    <table class="table table-bordered mt-3">
        <tr>
            <th>ID</th>
            <td>{{ $business->id }}</td>
        </tr>
        <tr>
            <th>Business Name</th>
            <td>{{ $business->business_name }}</td>
        </tr>
        <tr>
            <th>Owner</th>
            <td>{{ $business->owner->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $business->owner->email ?? '-' }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $business->owner->phone ?? '-' }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $business->description ?? '-' }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $business->address ?? '-' }}</td>
        </tr>
        <tr>
            <th>City</th>
            <td>{{ $business->city ?? '-' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($business->status) }}</td>
        </tr>
        <tr>
            <th>Slots</th>
            <td>{{ $business->slots ?? 0 }}</td>
        </tr>
    </table>

    <h4 class="mt-4">Services</h4>
    @if($services->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Service Name</th>
                <th>Price</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                <td>{{ $service->name }}</td>
                <td>{{ $service->price }}</td>
                <td>{{ $service->description ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No services added yet.</p>
    @endif

    <h4 class="mt-4">Service Requests</h4>
    @if($requests->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Client</th>
                <th>Worker</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
            <tr>
                <td>{{ $request->id }}</td>
                <td>{{ $request->client->name ?? '-' }}</td>
                <td>{{ $request->worker->user->name ?? '-' }}</td>
                <td>{{ ucfirst($request->status) }}</td>
                <td>{{ $request->created_at->format('d M, Y') ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No service requests yet.</p>
    @endif

    <a href="{{ route('superadmin.businesses') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
