@extends('business.layout')

@section('title','Edit Shift')

@section('content')
<div class="container">
    <h3>Edit Shift</h3>

    <form method="POST" action="{{ route('business.workers.shift.update', $shift->id) }}">
        @csrf
        @method('PUT')
        <!-- IMPORTANT -->

        <!-- ye zaroori hai PUT route ke liye -->

        <div class="mb-3">
            <label>Start Time</label>
            <input type="time" name="shift_start" value="{{ $shift->shift_start }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>End Time</label>
            <input type="time" name="shift_end" value="{{ $shift->shift_end }}" class="form-control" required>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('business.workers.shifts') }}" class="btn btn-secondary">Cancel</a>
    </form>

</div>
@endsection