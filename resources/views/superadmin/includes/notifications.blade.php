@extends('superadmin.layout')

@section('title', 'Notifications')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0 fw-bold">Notifications</h3>
        <form action="{{ route('superadmin.notifications.markAllRead') }}" method="POST">
            @csrf
            <button class="btn btn-sm btn-primary">Mark all as read</button>
        </form>
    </div>
    <div class="card-body" style="max-height: 660px; overflow-y: auto;">
        @if($notifications->count() > 0)
            <ul class="list-group">
                @foreach($notifications as $note)
                    <li class="list-group-item {{ is_null($note->read_at) ? 'bg-light' : '' }}">
                        <a href="{{ $note->data['link'] ?? '#' }}">
                            {{ $note->data['message'] ?? 'No message' }}
                        </a>
                        <span class="text-muted float-end" style="font-size: 0.8rem;">
                            {{ $note->created_at->diffForHumans() }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted text-center">No notifications found.</p>
        @endif
    </div>
</div>
<div class="d-flex justify-content-center">
    {{ $notifications->links('vendor.pagination.bootstrap-5') }}
</div>
@endsection
