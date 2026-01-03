@extends('client.layout')
@section('title', 'Dashboard')

@section('content')
<h3 class="fw-bold mb-3">Welcome, {{ auth()->user()->name }}</h3>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card p-4 shadow-sm">
            <h4>Browse Businesses</h4>
            <p class="text-muted">Find service providers and send them requests.</p>
            <a href="{{ route('client.businesses') }}" class="btn btn-primary">View Businesses</a>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card p-4 shadow-sm">
            <h4>My Requests</h4>
            <p class="text-muted">Track your service request status.</p>
            <a href="{{ route('client.requests') }}" class="btn btn-primary">View Requests</a>
        </div>
    </div>
    
</div>
@endsection
