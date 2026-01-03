@extends('business.layout')
@section('title','Assign Worker Shift')

@section('content')
<div class="container">
    <h4>Assign Shift – {{ $worker->user->name ?? $worker->name }}</h4>

    <form method="POST" action="{{ route('business.workers.shift.update', $worker->id) }}">
        @csrf

        <div class="mb-3">
            <label>Shift Start</label>
            <input type="time" name="shift_start" class="form-control"
                   value="{{ $worker->shift_start }}" required>
        </div>

        <div class="mb-3">
            <label>Shift End</label>
            <input type="time" name="shift_end" class="form-control"
                   value="{{ $worker->shift_end }}" required>
        </div>

        <button class="btn btn-primary">Save Shift</button>
    </form>
</div>
@endsection
