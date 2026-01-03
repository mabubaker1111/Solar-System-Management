@extends('client.layout')
@section('title', 'Notifications')

@section('content')
<div class="card p-4">
    <h3>Notifications</h3>
    <form action="{{ route('client.notifications.markAllRead') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success btn-sm mb-3">Mark all as read</button>
    </form>

    @if($notifications->count() > 0)
        <ul class="list-group">
            @foreach($notifications as $note)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ $note->data['link'] ?? '#' }}">
                    {!! $note->data['message'] ?? 'No message' !!}
                </a>
                @if(!$note->read_at)
                    <span class="badge bg-warning">New</span>
                @endif
            </li>
            @endforeach
        </ul>
    @else
        <p>No notifications found.</p>
    @endif
</div>
<div class="d-flex justify-content-center">
        {{ $notifications->links('vendor.pagination.bootstrap-5') }}
    </div>
@endsection
