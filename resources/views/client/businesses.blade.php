@extends('client.layout')
@section('title', 'Browse Businesses')

@section('content')
<h3 class="fw-bold mb-4">Available Businesses</h3>

<div class="row">
@foreach($businesses as $b)
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column">
                <h5 class="fw-bold">Name: {{ $b->business_name }}</h5>
                <p class="mt-2 text-muted">Description: {{ Str::limit($b->description,70) }}</p>
                <p class="mt-0 text-muted">Location: {{ Str::limit($b->address,70) }}</p>
                <div class="mt-auto">
                    <a href="{{ route('client.business.details', $b->id) }}" class="btn btn-outline-primary btn-sm w-100">View Details</a>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection
