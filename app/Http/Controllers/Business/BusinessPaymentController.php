<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Worker\ServicePayment;
use Illuminate\Support\Facades\Auth;

class BusinessPaymentController extends Controller
{
    // Business ke liye payments list
    public function index()
    {
        // Payments fetch kar rahe jahan ye business involved ho
        $payments = ServicePayment::with(['serviceRequest', 'serviceRequest.worker'])
            ->latest()
            ->paginate(10);

        return view('business.payments.index', compact('payments'));
    }

    // Payment status change karna
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,clear',
        ]);

        $payment = ServicePayment::findOrFail($id);
        $payment->payment_status = $request->payment_status;
        $payment->save();

        return back()->with('success', 'Payment status updated successfully.');
    }
}
