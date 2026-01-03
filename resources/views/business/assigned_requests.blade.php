@extends('business.layout')

@section('content')
<h3>Assigned Requests</h3>

@if($requests->count())
<table class="table table-striped">
    <thead>
        <tr>
            <th>Client</th>
            <th>Service</th>
            <th>Worker</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($requests as $req)
        <tr>
            <td>{{ $req->client->name ?? 'N/A' }}</td>
            <td>{{ $req->service->name ?? 'N/A' }}</td>
            <td>{{ $req->worker->user->name ?? 'N/A' }}</td>
            <td>
                <span class="badge bg-info">{{ ucfirst($req->status) }}</span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>No assigned requests yet.</p>
@endif
@endsection
