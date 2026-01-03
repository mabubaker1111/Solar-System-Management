@extends('business.layout')

@section('title', 'Worker Shifts')

@section('content')
<div class="container">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Worker Shifts</h3>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($workers->isEmpty())
        <div class="alert alert-warning">
            No workers found.
        </div>
    @else

        {{-- Worker wise shifts --}}
        @foreach($workers as $worker)
            <div class="card rounded-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>
                        <i class="fas fa-user me-2"></i>
                        {{ $worker->user->name ?? 'Worker' }}
                    </strong>

                    {{-- ADD SHIFT BUTTON --}}
                    <a href="{{ route('business.workers.shift.add', $worker->id) }}"
                       class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add Shift
                    </a>
                </div>

                <div class="card-body p-0">
                    @if($worker->shifts->count() == 0)
                        <div class="p-3 text-muted">
                            No shifts added yet.
                        </div>
                    @else
                        <table class="table table-bordered table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th width="140">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($worker->shifts as $index => $shift)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $shift->shift_start }}</td>
                                        <td>{{ $shift->shift_end }}</td>

                                        <td class="d-flex gap-2">

                                            {{-- EDIT --}}
                                            <a href="{{ route('business.workers.shift.edit', $shift->id) }}"
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- DELETE --}}
                                            <form action="{{ route('business.workers.shift.delete', $shift->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Delete this shift?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        @endforeach

    @endif
</div>
@endsection
