@extends('frontend.partials.mainfile')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4 text-center">Available Businesses</h2>

    <div class="row">
        @foreach($businesses as $b)
            <div class="col-md-4 mb-3">
                <div class="card p-3 shadow-sm h-100">
                    <h5>{{ $b->business_name }}</h5>
                    <p>{{ Str::limit($b->description, 70) }}</p>
                    <a href="{{ route('client.business.details', $b->id) }}" class="btn btn-sm btn-primary">View Details</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
