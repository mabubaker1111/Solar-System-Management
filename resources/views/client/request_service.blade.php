@extends('client.layout')
@section('title','Request Service')

@section('content')
<div class="container mt-4">
    <h2>Request Service</h2>

    <div class="card p-4 shadow-sm">
        <h4>{{ $service->name }}</h4>
        <p><strong>Price:</strong> PKR {{ $service->price }}</p>
        <p>{{ $service->description }}</p>

        <form action="{{ route('client.request.store') }}" method="POST">
            @csrf
            <input type="hidden" name="service_id" value="{{ $service->id }}">
            <input type="hidden" name="business_id" value="{{ $service->business->id }}">

            <div class="mb-3">
                <label class="form-label">Additional Notes (Optional)</label>
                <textarea name="notes" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="datetime-local" name="deadline" id="deadline" class="form-control" required>
            </div>


            <div class="mb-4">
                <h5>Notifications ({{ $unreadCount }})</h5>
                <ul class="list-group mb-3">
                    @foreach($notifications as $note)
                    <li class="list-group-item">
                        <a href="{{ $note->data['link'] }}">
                            {{ $note->data['message'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <button class="btn btn-primary w-100">Submit Request</button>
        </form>
    </div>
</div>
@endsection