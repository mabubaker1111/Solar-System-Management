@extends('business.layout')
@section('title','Payment Details')
@section('content')
<div class="container">
    <h3 class="mb-4">Payment Details</h3>
    <div class="table-responsive rounded-card shadow-lg">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Worker</th>
                    <th>Full Payment</th>
                    <th>Discount</th>
                    <th>Final Amount</th>
                    <th>Quantity</th>
                    <th>Received</th>
                    <th>Remaining</th>
                    <th>Comments</th>
                    <th>Paymnet Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->service_name }}</td>
                    <td>{{ optional($payment->serviceRequest->worker->user)->name }}</td>
                    <td>{{ $payment->full_payment }}</td>
                    <td>{{ $payment->discount }}</td>
                    <td>{{ $payment->final_amount }}</td>
                    <td>{{ $payment->quantity ?? 1 }}</td>
                    <td>{{ $payment->received_amount }}</td>
                    <td>{{ $payment->remaining_amount }}</td>
                    <td>{{ $payment->comment ?? '-' }}</td>
                    <td>{{ ucfirst($payment->payment_status) }}</td>
                    <td>
                        <form action="{{ route('business.payments.updateStatus', $payment->id) }}" method="POST">
                            @csrf
                            <select name="payment_status" class="form-select form-select-sm">
                                <option value="pending" {{ $payment->payment_status == 'pending' ? 'selected' : ''
                                    }}>Pending</option>
                                <option value="clear" {{ $payment->payment_status == 'clear' ? 'selected' : '' }}>Clear
                                </option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary mt-1">Update</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $payments->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
@endsection