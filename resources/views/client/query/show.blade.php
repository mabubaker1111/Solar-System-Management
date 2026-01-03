@extends('client.layout')
@section('title', 'Query Details')

@section('content')
<div class="card p-4">
    <h3>Business Reply</h3>

    <div class="mb-3">
        <strong>Business Name:</strong>
        <p>{{ $query->business->business_name ?? 'N/A' }}</p>
    </div>

    <div class="mb-3">
        <strong>Your Message:</strong>
        <p>{{ $query->message }}</p>
    </div>

    <div class="mb-3">
        <strong>Business Reply:</strong>
        <p>
            @if($query->response)
                {{ $query->response }}
            @else
                Not replied yet
            @endif
        </p>
        
    </div>
</div>


@php
    if($query->response && !$query->read_by_client) {
        $query->update(['read_by_client' => true]);
    }
@endphp
@endsection
