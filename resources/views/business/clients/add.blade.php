@extends('business.layout')

@section('title','Add Client')

@section('content')
<div class="container">
    <h3 class="mb-4">Add New Client</h3>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('business.clients.store') }}" method="POST">
        @csrf
        <div class="row g-3">

            <div class="col-md-6">
                <label for="name" class="form-label">Client Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="password" required>
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6">
                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6">
                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="address" value="{{ old('address') }}" required>
                @error('address') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6">
                <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="city" value="{{ old('city') }}" required>
                @error('city') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6">
                <label for="service" class="form-label">Service <span class="text-danger">*</span></label>
                <select name="service_id" class="form-select" required>
                    <option value="">-- Select Service --</option>
                    @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
                @error('service_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6">
                <label for="deadline" class="form-label">Deadline <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="deadline" value="{{ old('deadline') }}" required>
                @error('deadline') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6">
                <label for="worker" class="form-label">Assign Worker <span class="text-danger">*</span></label>

                <select name="worker_shift_id" class="form-control" required>
                    @foreach($workers as $worker)
                    @foreach($worker->shifts as $shift)
                    @php
                    $booked = $shift->bookings->where('booking_date', $request_date)->isNotEmpty();
                    @endphp
                    @if(!$booked)
                    <option value="{{ $shift->id }}">
                        {{ $worker->user->name }} - {{ $shift->shift_start }} to {{ $shift->shift_end }}
                    </option>
                    @endif
                    @endforeach
                    @endforeach
                </select>




                @error('worker_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Description / Notes</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                <small class="text-muted">This will be saved in Service Requests if assigned.</small>
            </div>


        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Add Client</button>
            <a href="{{ route('business.dashboard') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection