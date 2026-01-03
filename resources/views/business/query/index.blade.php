@extends('business.layout')
@section('title', 'Client Queries')

@section('content')
<h3 class="mb-4">Client Queries</h3>

@if($queries->count() > 0)
    <div class="list-group">
        @foreach($queries as $query)
            <a href="{{ route('business.query.show', $query->id) }}" class="list-group-item list-group-item-action">
                <strong>{{ $query->client->name ?? 'N/A' }}</strong> - {{ Str::limit($query->message, 50) }}
                @if($query->response)
                    <span class="badge bg-success float-end">Replied</span>
                @else
                    <span class="badge bg-warning text-dark float-end">Pending</span>
                @endif
            </a>
        @endforeach
    </div>
@else
    <p>No client queries yet.</p>
@endif
@endsection
