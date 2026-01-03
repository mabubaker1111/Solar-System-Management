@extends('worker.layouts.app')
@section('title','Worker Profile')

@section('content')
<div class="container mt-4">
    <h3>{{ $worker->user->name }} - Profile</h3>
    <div class="card p-4 shadow-sm">
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Email:</strong> {{ $worker->user->email }}</li>
            <li class="list-group-item"><strong>Phone:</strong> {{ $worker->user->phone }}</li>
            <li class="list-group-item"><strong>Skill:</strong> {{ $worker->skill ?? 'N/A' }}</li>
            <li class="list-group-item"><strong>Experience:</strong> {{ $worker->experience ?? 'N/A' }}</li>
            <li class="list-group-item"><strong>Business:</strong> {{ $worker->business->business_name ?? 'N/A' }}</li>
            <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($worker->status) }}</li>
        </ul>
    </div>
</div>
@endsection
