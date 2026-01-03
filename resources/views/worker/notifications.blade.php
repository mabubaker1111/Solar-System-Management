@extends('worker.layouts.app')
@section('title', 'Worker Notifications')

@section('content')
<div class="container">
    <h3 class="mb-4">Notifications</h3>

    @if($notifications->count() > 0)
        <div class="list-group shadow-sm rounded-3" style="max-height: 400px; overflow-y: auto; overflow-x: hidden;">
    @foreach($notifications as $note)
        <li class="list-group-item d-flex justify-content-between align-items-center {{ $note->read_at ? 'list-group-item-secondary' : 'list-group-item-info' }}">
            <span>{{ $note->data['message'] ?? 'No message' }}</span>
            @if(isset($note->data['link']))
                {{-- <a href="{{ $note->data['link'] }}" class="btn btn-sm btn-primary">View</a> --}}
            @endif
        </li>
    @endforeach
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
        <div class="alert alert-light">No notifications</div>
    @endif
</div>
@endsection
