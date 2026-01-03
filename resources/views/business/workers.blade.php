@extends('business.layout')
@section('title','Workers List')

@section('content')
<div class="container">
    <h3 class="mb-4 fw-bold">Workers in Your Business</h3>

    @if($workers->count() == 0)
    <div class="alert alert-warning">No workers assigned yet.</div>
    @else
    <div class="row">
        @foreach($workers as $worker)
        <div class="col-md-4 mb-4">
            <div class="card worker-card shadow-lg border-0">
                <div class="card-body text-center p-4">

                    <div class="profile-img-wrapper mb-3">
                        <img src="{{ $worker->photo ? asset('storage/'.$worker->photo) : 'https://via.placeholder.com/150' }}"
                            alt="Worker Photo" class="img-fluid rounded-circle profile-img">
                    </div>

                    <h5 class="worker-name mb-1">{{ $worker->user->name ?? 'N/A' }}</h5>
                    <p class="text-muted mb-2">{{ $worker->skill ?? 'N/A' }}</p>

                    <p class="worker-info">
                        <strong>Experience:</strong> {{ $worker->experience ?? 'N/A' }} years
                    </p>

                    <p class="worker-status">
                        <strong>Status:</strong>
                        <span class="badge px-3 py-2 
                    {{ $worker->status == 'approved' ? 'bg-success' : 'bg-warning' }}">
                            {{ ucfirst($worker->status) }}
                        </span>
                    </p>

                </div>
            </div>
        </div>

        @endforeach
    </div>
    @endif
</div>
<style>
    /* Google Font */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

    .worker-card {
        border-radius: 18px;
        transition: all 0.3s ease;
        background: #ffffff;
        border-block-color: 
        font-family: 'Poppins', sans-serif;
    }

    .worker-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }

    .profile-img-wrapper {
        width: 130px;
        height: 130px;
        margin: auto;
        border-radius: 50%;
        padding: 5px;
        background: linear-gradient(45deg, #4e98e7, #19e9b8);
    }

    .profile-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #fff;
    }

    .worker-name {
        font-weight: 600;
        font-size: 20px;
        color: #333;
    }

    .worker-info {
        font-size: 15px;
        color: #555;
        margin-bottom: 10px;
    }

    .badge {
        font-size: 13px;
        border-radius: 12px;
    }
</style>
@endsection