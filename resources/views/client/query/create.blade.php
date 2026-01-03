@extends('client.layout')
@section('title', 'Send Query')

@section('content')
<div class="card p-4">
    <h3 class="mb-4">Send Query to Business</h3>

    <form action="{{ route('client.query.store') }}" method="POST">
        @csrf
        <input type="hidden" name="business_id" value="{{ $business_id }}">

        <div class="mb-3">
            <label>Message</label>
            <textarea name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Send</button>
    </form>
</div>
@endsection
