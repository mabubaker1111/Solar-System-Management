@extends('business.layout')

@section('title', 'Client Requests')

@section('content')
<h3 class="text-center">All Client Request</h3>
<div class="table-container">
    <table class="responsive-table">
        <caption class="fs-6 text-center fw-bold">All Registered Businesses</caption>
        <thead>
            <tr>
                <th>Client Name</th>
                <th>Service</th>
                <th>Status</th>
                <th>Deadline</th>
                <th>Description</th>
                <th>Price</th>
                <th>Assign Worker</th>
                <th>Completed</th>
            </tr>
        </thead>

        <tbody>
            @forelse($requests as $req)
            <tr>
                <td data-title="Client Name">{{ $req->client->name ?? 'Unknown Client' }}</td>
                <td data-title="Service">{{ $req->service->name ?? 'Unknown Service' }}</td>

                <td data-title="Status">
                    @if($req->status == 'pending') Pending
                    @elseif($req->status == 'approved') Approved
                    @elseif($req->status == 'assigned') Assigned to {{ $req->worker->user->name ?? 'N/A' }}
                    @elseif($req->status == 'rejected') Rejected
                    @elseif($req->status == 'completed') Completed
                    @endif
                </td>

                <td data-title="Deadline">
                    {{ $req->deadline ? \Carbon\Carbon::parse($req->deadline)->format('d-M-Y') : '-' }}
                </td>

                <td data-title="Description">{{ $req->notes ?? '-' }}</td>
                <td data-title="Price">{{ $req->price ?? '-' }}</td>
                <td data-title="Assign Worker">
                    @if($req->status == 'pending' || $req->status == 'approved')
                    <form method="POST" action="{{ route('business.assign.worker') }}" class="assign-form">
                        @csrf
                        <input type="hidden" name="request_id" value="{{ $req->id }}">

                        <select name="worker_id" class="form-select form-select-sm" required>
                            <option value="">-- Select Worker --</option>
                            @foreach($workers as $w)
                            @if($w->status == 'approved')
                            <option value="{{ $w->id }}">{{ $w->user->name }}</option>
                            @endif
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-primary btn-sm">Assign</button>
                    </form>
                    @else
                    <span class="text-success">Assigned</span>
                    @endif
                </td>

                <td data-title="Completed">
                    @if($req->status != 'completed')
                    <form method="POST" action="{{ route('business.request.complete', $req->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">Mark</button>
                    </form>
                    @else
                    <span class="text-success fw-bold">Completed</span>
                    @endif
                    <div class="modal fade" id="completeModal{{ $req->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('worker.request.complete', $req->id) }}" method="POST">
                                @csrf
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Complete Task</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label>Service Name</label>
                                            <input type="text" class="form-control" value="{{ $req->service->name }}"
                                                readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label>Full Payment</label>
                                            <input type="number" class="form-control full-payment" name="full_payment"
                                                value="{{ $req->price }}" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label>Quantity</label>
                                            <input type="number" class="form-control quantity" name="quantity" value="1"
                                                min="1">
                                        </div>

                                        <div class="mb-3">
                                            <label>Discount</label>
                                            <input type="number" class="form-control discount" name="discount" value="0"
                                                min="0">
                                        </div>

                                        <div class="mb-3">
                                            <label>Final Amount</label>
                                            <input type="number" class="form-control final-amount" name="final_amount"
                                                readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label>Received Amount</label>
                                            <input type="number" class="form-control received" name="received_amount"
                                                value="0" min="0">
                                        </div>

                                        <div class="mb-3">
                                            <label>Remaining Amount</label>
                                            <input type="number" class="form-control remaining-amount"
                                                name="remaining_amount" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label>Comment</label>
                                            <textarea class="form-control" name="comment"
                                                placeholder="Optional notes"></textarea>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No requests found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $requests->links('vendor.pagination.bootstrap-5') }}
</div>
<style>
    .table-container {
        max-height: 550px;
        overflow-y: auto;
        overflow-x: auto;
        width: 100%;
        border-radius: 0.25rem;
        position: relative;
    }

    .table-container::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    .table-container::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 3px;
    }

    .responsive-table {
        width: 120%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .responsive-table th,
    .responsive-table td {
        padding: 0.7em;
        border: 1px solid rgba(134, 188, 37, 0.8);
        text-align: center;
        vertical-align: middle;
    }

    .responsive-table thead th {
        background: linear-gradient(#4e73df, #1cc88a);
        color: white;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    .responsive-table tbody tr:nth-child(even) {
        background-color: rgba(0, 0, 0, .05);
    }

    .assign-form {
        display: flex;
        gap: 6px;
        align-items: center;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .responsive-table thead {
            position: absolute;
            clip: rect(1px 1px 1px 1px);
            height: 1px;
            width: 1px;
            overflow: hidden;
        }

        .responsive-table tr,
        .responsive-table td {
            display: block;
            text-align: right;
            position: relative;
        }

        .responsive-table td[data-title]:before {
            content: attr(data-title);
            position: absolute;
            left: 0;
            width: 50%;
            padding-left: 10px;
            font-weight: bold;
            text-align: left;
        }
    }
</style>

@endsection