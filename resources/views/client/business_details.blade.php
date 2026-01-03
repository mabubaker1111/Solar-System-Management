@extends('client.layout')
@section('title', 'Business Details')

@section('content')
<h2 class="fw-bold mb-4">Business Details</h2>

<div class="card p-4 shadow-sm">
    <div class="d-flex">
        <img src="{{ asset('uploads/business/' . $business->image) }}" style="width:150px;height:150px;object-fit:cover;border-radius:10px;" alt="Business Image">

        <div class="ms-4">
            <p><strong>Email:</strong> {{ $business->owner->email ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $business->owner->phone ?? 'N/A' }}</p>
            <p><strong>Business Owner:</strong> {{ $business->owner->name ?? 'N/A' }}</p>
            <p><strong>Business Name:</strong> {{ $business->business_name ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $business->address ?? 'N/A' }}</p>
            <p><strong>City:</strong> {{ $business->city ?? 'N/A' }}</p>
            <p><strong>Description:</strong> {{ $business->description ?? 'N/A' }}</p>
        </div>
    </div>
</div>

<hr>

<h3 class="fw-bold mt-4">Available Services</h3>

@foreach($business->services as $service)
<div class="card shadow-sm p-3 my-3">
    <h5 class="fw-bold">{{ $service->name }}</h5>
    <h6 class="text-success">PKR {{ $service->price }}</h6>
    <p>{{ $service->description }}</p>
    <a href="{{ route('client.request.service', $service->id) }}" class="btn btn-primary">Request This Service</a>
</div>
@endforeach
@endsection
