@extends('business.layout')

@section('content')
<h3>Add Shift for {{ $worker->user->name ?? $worker->name }}</h3>

<form action="{{ route('business.workers.shifts.store', $worker->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Shift Start</label>
        <input type="time" name="shift_start" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Shift End</label>
        <input type="time" name="shift_end" class="form-control" required>
    </div>
    <button class="btn btn-primary">Add Shift</button>
</form>
@endsection
