@extends('business.layout')
@section('title','Assign Shift')

@section('content')
<h3>Assign Shift for Request #{{ $request->id }}</h3>
<form action="{{ route('workers.shifts.assign') }}" method="POST">
    @csrf
    <input type="hidden" name="client_request_id" value="{{ $request->id }}">

    <label>Select Worker & Shift</label>
    <select name="worker_shift_id" required>
        @foreach($workers as $worker)
        @foreach($worker->shifts as $shift)
        @php
        $alreadyBooked = \App\Models\WorkerShiftBooking::where('worker_shift_id', $shift->id)
        ->where('booking_date', $request_date)
        ->exists();
        @endphp

        @if(!$alreadyBooked)
        <option value="{{ $shift->id }}">
            {{ $worker->user->name }} - {{ $shift->shift_start }} to {{ $shift->shift_end }}
        </option>
        @endif
        @endforeach
        @endforeach
    </select>

    <label>Booking Date</label>
    <input type="date" name="booking_date" value="{{ $request_date }}" required>

    <button type="submit">Assign Shift</button>
</form>

@endsection