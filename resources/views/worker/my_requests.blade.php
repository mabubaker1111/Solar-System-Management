@extends('worker.layouts.app')
@section('title','My Requests')

@section('content')
<div class="container">
    <h3 class="mb-4">My Assigned Requests</h3>

    @if($requests->count())
    <div class="table-responsive  rounded-card shadow-lg">
        <table class="table-info table-hover align-middle">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Client Email</th>
                    <th>Client Phone</th>
                    <th>Business</th>
                    <th>Service</th>
                    <th>Notes</th>
                    <th>Status</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Deadline</th>
                    <th>Worker Mood</th>
                    <th>Complete?</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $req)
                <tr>
                    <td>{{ optional($req->client)->name ?? 'N/A' }}</td>
                    <td>{{ optional($req->client)->email ?? 'N/A' }}</td>
                    <td>{{ optional($req->client)->phone ?? 'N/A' }}</td>
                    <td>{{ optional($req->business)->business_name ?? 'N/A' }}</td>
                    <td>{{ optional($req->service)->name ?? 'N/A' }}</td>
                    <td>{{ $req->notes ?? '-' }}</td>
                    <td>
                        <span class="badge 
                            @if($req->status === 'pending') bg-warning
                            @elseif($req->status === 'approved') bg-success
                            @elseif($req->status === 'assigned') bg-info
                            @elseif($req->status === 'rejected') bg-danger
                            @elseif($req->status === 'completed') bg-secondary
                            @endif">
                            {{ ucfirst($req->status) }}
                        </span>
                    </td>
                    <td data-title="Price">{{ $req->price ?? '-' }}</td>
                    <td>{{ $req->date }}</td>
                    <td>{{ $req->time }}</td>
                    <td class="py-3 text-center">
                        {{ $req->deadline ? \Carbon\Carbon::parse($req->deadline)->format('d-M-Y') : '-' }}
                    </td>
                    <td>
                        @if($req->status === 'assigned')
                        <form action="{{ route('worker.request.accept', $req->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Accept</button>
                        </form>

                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#cancelModal{{ $req->id }}">
                            Cancel
                        </button>

                        <div class="modal fade" id="cancelModal{{ $req->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('worker.request.cancel', $req->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Cancel Task</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="reason">Reason for cancellation</label>
                                                <textarea name="reason" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">Submit</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @elseif($req->status === 'approved')
                        <span class="badge bg-success">Done</span>
                        @elseif($req->status === 'cancelled')
                        <span class="badge bg-danger">Cancelled</span>
                        @else
                        <span class="text-muted">{{ ucfirst($req->status) }}</span>
                        @endif
                    </td>
                    <td>
                        @if(in_array(strtolower(trim($req->status)), ['assigned', 'approved']))
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#completeModal{{ $req->id }}">
                            Complete
                        </button>
                        @foreach ($requests as $req)
                        <!-- Complete Modal -->
                        <!-- Complete Modal -->
                        <div class="modal fade" id="completeModal{{ $req->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('worker.payments.store', $req->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Complete Task</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <div class="mb-3">
                                                <label>Service Name</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $req->service->name }}" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label>Full Payment</label>
                                                <input type="number" class="form-control full-payment"
                                                    name="full_payment" value="{{ $req->price }}" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label>Quantity</label>
                                                <input type="number" class="form-control quantity" name="quantity"
                                                    value="1" min="1">
                                            </div>

                                            <div class="mb-3">
                                                <label>Discount</label>
                                                <input type="number" class="form-control discount" name="discount"
                                                    value="0" min="0">
                                            </div>

                                            <div class="mb-3">
                                                <label>Final Amount</label>
                                                <input type="number" class="form-control final-amount"
                                                    name="final_amount" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label>Received Amount</label>
                                                <input type="number" class="form-control received"
                                                    name="received_amount" value="0" min="0">
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


                        @endforeach

                        @elseif(strtolower(trim($req->status)) === 'completed')
                        <span class="badge bg-secondary">Completed</span>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-muted">No requests assigned yet.</p>
    @endif
</div>
<div class="d-flex justify-content-center">
    {{ $requests->links('vendor.pagination.bootstrap-5') }}
</div>

<style>
    .table-wrapper {
        max-width: 100%;
        overflow-x: auto;
        padding-bottom: 10px;
    }

    /* Table styling */
    table.table {
        width: 1500px;
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    thead th {
        padding: 14px 20px;
        font-size: 15px;
        /* background-color: blue; */
        background: linear-gradient(#4e73df, #1cc88a);
        color: white;
        white-space: nowrap;
    }

    tbody td {
        padding: 14px 20px !important;
        background: #fff;
        border-top: 1px solid #e5e5e5;
        white-space: nowrap;
    }

    tbody tr {
        border-radius: 10px;
        overflow: hidden;
    }

    .rounded-card {
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.07);
    }
</style>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.modal').forEach(modal => {
        const fullInput = modal.querySelector('.full-payment');
        const quantityInput = modal.querySelector('.quantity');
        const discountInput = modal.querySelector('.discount');
        const receivedInput = modal.querySelector('.received');
        const finalAmountInput = modal.querySelector('.final-amount');
        const remainingInput = modal.querySelector('.remaining-amount');

        function updateAmounts() {
            let full = parseFloat(fullInput.value) || 0;
            let qty = parseFloat(quantityInput.value) || 1;
            let discount = parseFloat(discountInput.value) || 0;
            let received = parseFloat(receivedInput.value) || 0;

            let finalPay = (full * qty) - discount;
            if (finalPay < 0) finalPay = 0;

            let remaining = finalPay - received;
            if (remaining < 0) remaining = 0;

            finalAmountInput.value = finalPay;
            remainingInput.value = remaining;
        }

        quantityInput.addEventListener('input', updateAmounts);
        discountInput.addEventListener('input', updateAmounts);
        receivedInput.addEventListener('input', updateAmounts);

        updateAmounts(); // Initialize
    });
});
</script>

@endsection