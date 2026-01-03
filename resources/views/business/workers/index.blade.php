@extends('business.layout')
@section('title','My Workers')

@section('content')
<div class="container">
    <h3 class="mb-4">Workers Under Your Business</h3>

    @if($workers->count() == 0)
        <div class="alert alert-warning">No workers added yet.</div>
    @endif

    <div class="row">
        @foreach($workers as $worker)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">

                    @if($worker->photo)
                        <img src="{{ asset('storage/'.$worker->photo) }}" 
                             class="img-fluid rounded-circle mb-3" width="120">
                    @else
                        <img src="https://via.placeholder.com/120"
                             class="img-fluid rounded-circle mb-3">
                    @endif

                    <h5>{{ $worker->user->name }}</h5>
                    <p class="text-muted">{{ $worker->user->email }}</p>

                    <ul class="list-group list-group-flush text-start">
                        <li class="list-group-item"><strong>Phone:</strong> {{ $worker->user->phone }}</li>
                        <li class="list-group-item"><strong>Skill:</strong> {{ $worker->skill ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Experience:</strong> {{ $worker->experience ?? 'N/A' }}</li>

                        <li class="list-group-item">
                            <strong>Status:</strong>
                            <span class="badge {{ $worker->status == 'approved' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($worker->status) }}
                            </span>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
