@extends('business.layout')
@section('title', 'Query Details')

@section('content')
<div class="card p-4">
    <h3 class="mb-4">Query from {{ $query->client->name ?? 'N/A' }}</h3>

    <div class="mb-3">
        <strong>Client Message:</strong>
        <p>{{ $query->message ?? 'N/A' }}</p>
    </div>

    <div class="mb-3">
        <strong>Response:</strong>
        <p>{{ $query->response ?? 'No reply yet' }}</p>
    </div>

    @if(!$query->response)
        <form action="{{ route('business.query.reply', $query->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Reply</label>
                <textarea name="response" class="form-control" rows="4" required>{{ old('response') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Send Reply</button>
        </form>
    @endif
</div>
@endsection
