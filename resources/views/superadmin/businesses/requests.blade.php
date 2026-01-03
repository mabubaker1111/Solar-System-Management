@extends('business.layout')

@section('title', 'Client Requests')

@section('content')
<div class="container mt-4">
    <h3>Client Requests</h3>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Service</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
            <tr>
                <td>{{ $request->id }}</td>
                <td>{{ $request->client->name ?? '-' }}</td>
                <td>{{ $request->service->name ?? '-' }}</td>
                <td>{{ ucfirst($request->status) }}</td>
                <td>
                    @if($request->status == 'pending')
                        <form action="{{ route('business.request.accept', $request->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form action="{{ route('business.request.reject', $request->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
