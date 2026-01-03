@extends('client.layout')
@section('title', 'Business Details')

@section('content')

<h3 class="fw-bold">{{ $business->name }}</h3>
<p class="text-muted">{{ $business->description }}</p>

<hr>

<h4 class="mb-3">Services Offered</h4>

<form action="{{ route('client.service.request') }}" method="POST">
    @csrf

    <input type="hidden" name="business_id" value="{{ $business->id }}">

    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">Select Service</label>
            <select name="service_id" class="form-control" required>
                <option value="">Choose Service</option>
                @foreach ($services as $s)
                    <option value="{{ $s->id }}">{{ $s->name }} (Rs {{ $s->price }})</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">Time</label>
            <input type="time" name="time" class="form-control" required>
        </div>

    </div>

    <button class="btn btn-primary mt-3">Send Request</button>
</form>

@endsection
