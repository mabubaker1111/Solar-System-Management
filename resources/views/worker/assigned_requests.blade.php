@extends('worker.layouts.app')
@section('title','Assigned Requests')

@section('content')
<div class="container">
    <h3 class="mb-4">Assigned Requests</h3>

    @if($requests->count())
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th>Client</th>
                    <th>Client Contact</th>
                    <th>Business</th>
                    <th>Notes</th>
                    <th>Requested At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $r->service->name ?? 'N/A' }}</td>
                    <td>{{ $r->client->name ?? 'N/A' }}</td>
                    <td>
                        Email: {{ $r->client->email ?? 'N/A' }}<br>
                        Phone: {{ $r->client->phone ?? 'N/A' }}
                    </td>
                    <td>{{ $r->business->business_name ?? 'N/A' }}</td>
                    <td>{{ $r->notes ?? '-' }}</td>
                    <td>{{ optional($r->created_at)->format('d M, Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-muted">No assigned requests yet.</p>
    @endif
</div>
@foreach($requests as $req)
<div>
    Request #{{ $req->id }} | Client: {{ $req->client->name }} | Service: {{ $req->service->name }}
    <form action="{{ route('worker.requests.complete', $req->id) }}" method="POST">
        @csrf
        <input type="number" name="full_payment" placeholder="Full Payment" required>
        <input type="number" name="discount" placeholder="Discount">
        <input type="number" name="received_amount" placeholder="Received">
        <input type="text" name="comment" placeholder="Comment">
        <button type="submit">Complete</button>
    </form>
</div>
@endforeach
@endsection