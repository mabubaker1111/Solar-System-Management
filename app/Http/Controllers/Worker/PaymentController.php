<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Worker\Worker;
use App\Models\Client\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Worker\ServicePayment;


class PaymentController extends Controller
{
    public function index()
    {
        $worker = Worker::where('user_id', Auth::id())->firstOrFail();

        $payments = ServicePayment::where('worker_id', $worker->id)
            ->latest()
            ->paginate(10);

        return view('worker.payments.index', compact('payments'));
    }
    public function store(Request $request, $service_request_id)
    {
        $worker = Worker::where('user_id', Auth::id())->firstOrFail();
        $serviceRequest = ServiceRequest::findOrFail($service_request_id);

        $request->validate([
            'full_payment'    => 'required|numeric|min:0',
            'discount'        => 'nullable|numeric|min:0',
            'received_amount' => 'nullable|numeric|min:0',
            'comment'         => 'nullable|string|max:1000',
            'quantity'        => 'nullable|integer|min:1',
        ]);

        $quantity = $request->quantity ?? 1;
        $full_payment = $request->full_payment;
        $discount = $request->discount ?? 0;
        $received_amount = $request->received_amount ?? 0;

        $final_amount = ($full_payment * $quantity) - $discount;
        $remaining_amount = $final_amount - $received_amount;

        ServicePayment::create([
            'service_request_id' => $serviceRequest->id,
            'worker_id'          => $worker->id,
            'service_name'       => $serviceRequest->service->name,
            'quantity'           => $quantity,
            'full_payment'       => $full_payment,
            'discount'           => $discount,
            'received_amount'    => $received_amount,
            'final_amount'       => $final_amount,
            'remaining_amount'   => $remaining_amount,
            'comment'            => $request->comment,
            'payment_status'     => 'pending',
        ]);

        $serviceRequest->status = 'completed';
        $serviceRequest->save();

        return back()->with('success', 'Payment recorded successfully!');
    }
}
