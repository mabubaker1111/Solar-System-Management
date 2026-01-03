@extends('worker.layouts.app')
@section('title', 'Payment Details')

@section('content')
<div class="container">
    <h3 class="mb-4">My Payment Details</h3>

    @if($payments->count())
    <div class="table-responsive rounded-card shadow-lg">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Service Name</th>
                    <th>Quantity</th>
                    <th>Full Payment</th>
                    <th>Discount</th>
                    <th>Received Amount</th>
                    <th>Final Amount</th>
                    <th>Remaining Amount</th>
                    <th>Payment Status</th>
                    <th>Comment</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->service_name ?? '-' }}</td>
                    <td>{{ $payment->quantity ?? 1 }}</td>
                    <td>{{ number_format($payment->full_payment, 2) ?? '-' }}</td>
                    <td>{{ number_format($payment->discount, 2) ?? '0' }}</td>
                    <td>{{ number_format($payment->received_amount, 2) ?? '0' }}</td>
                    <td>{{ number_format($payment->final_amount, 2) ?? '-' }}</td>
                    <td>{{ number_format($payment->remaining_amount, 2) ?? '-' }}</td>
                    <td>
                        @if($payment->payment_status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                        @else
                        <span class="badge bg-success">Done</span>
                        @endif
                    </td>
                    <td>{{ $payment->comment ?? '-' }}</td>
                    <td>{{ $payment->created_at->format('d-M-Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $payments->links('vendor.pagination.bootstrap-5') }}
    </div>

    @else
    <p class="text-muted">No payment records found.</p>
    @endif
</div>

<style>
.table-responsive {
    overflow-x: auto;
}
table.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px;
}
thead th {
    padding: 12px 15px;
    background: #4e73df;
    color: white;
    white-space: nowrap;
}
tbody td {
    padding: 12px 15px;
    background: #fff;
    border-top: 1px solid #e5e5e5;
    white-space: nowrap;
}
.rounded-card {
    border-radius: 12px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.07);
}
</style>
@endsection
