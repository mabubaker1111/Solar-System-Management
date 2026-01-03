@extends('business.layout')
@section('title', 'Notifications')

@section('content')
<div class="container">
    <h3 class="mb-4">All Notifications</h3>

    <form action="{{ route('business.notifications.markAllRead') }}" method="POST" class="mb-3">
        @csrf
        <button class="btn btn-primary btn-sm">Mark All as Read</button>
    </form>

    @if($notifications->count() > 0)
        <div class="list-group shadow-sm rounded-3" style="max-height: 620px; overflow-y: auto; overflow-x: hidden;">
    @foreach($notifications as $note)
        <li class="list-group-item d-flex justify-content-between align-items-center {{ $note->read_at ? '' : 'fw-bold' }}">
            <span>{{ $note->data['message'] ?? 'No message' }}</span>
            <span class="text-muted ms-2" style="white-space: nowrap;">{{ $note->created_at->diffForHumans() }}</span>
        </li>
    @endforeach
</div>
<div class="d-flex justify-content-center">
        {{ $notifications->links('vendor.pagination.bootstrap-5') }}
    </div>

<style>
.list-group::-webkit-scrollbar {
    width: 6px;
}

.list-group::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2);
    border-radius: 3px;
}
</style>

    @else
        <p>No notifications found.</p>
    @endif
</div>
@endsection
