<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Worker\Worker;
use App\Models\Client\ServiceRequest;
use App\Models\Business\Service;
use App\Models\Worker\WorkerShift;
use App\Models\Worker\WorkerShiftBooking;
use Illuminate\Support\Facades\Auth;

class BusinessWorkerController extends Controller
{
    public function create()
    {
        // Workers with shifts and bookings loaded
        $workers = Worker::with('shifts.bookings', 'user')->get();

        // All services
        $services = Service::all();

        // Default date for booking check
        $request_date = now()->toDateString(); // ya jo date chahiye

        return view('business.client.add', compact('workers', 'services', 'request_date'));
    }

    // Show all workers
    public function index()
    {
        $businessId = Auth::user()->business->id;
        $workers = Worker::where('business_id', $businessId)->with('user', 'shifts.bookings')->get();
        return view('business.workers.index', compact('workers'));
    }


    public function editShift($shiftId)
    {
        $shift = \App\Models\Worker\WorkerShift::findOrFail($shiftId);
        return view('business.workers.edit_shift', compact('shift'));
    }

    public function updateShift(Request $request, $shiftId)
    {
        $request->validate([
            'shift_start' => 'required|date_format:H:i',
            'shift_end'   => 'required|date_format:H:i|after:shift_start',
        ]);

        $shift = \App\Models\Worker\WorkerShift::findOrFail($shiftId);

        $shift->update([
            'shift_start' => $request->shift_start,
            'shift_end'   => $request->shift_end,
        ]);

        return redirect()->route('business.workers.shifts')
            ->with('success', 'Shift updated successfully');
    }


    public function deleteShift($shiftId)
    {
        $shift = \App\Models\Worker\WorkerShift::findOrFail($shiftId);

        // Optional safety: agar booking ho chuki ho
        if ($shift->bookings()->exists()) {
            return back()->with('error', 'This shift is already booked and cannot be deleted');
        }

        $shift->delete();

        return back()->with('success', 'Shift deleted successfully');
    }


    public function addShift($workerId)
    {
        $worker = Worker::with('shifts')->findOrFail($workerId);
        return view('business.workers.add_shift', compact('worker'));
    }

    public function showAddShiftForm($requestId)
    {
        $request = \App\Models\Client\ServiceRequest::findOrFail($requestId);

        $workers = \App\Models\Worker\Worker::with('shifts.bookings')
            ->where('business_id', auth()->user()->business->id)
            ->get();

        // Agar request me date field hai to use karo, warna aaj ki date
        $request_date = $request->date ?? now()->toDateString();

        return view('business.workers.add', compact('workers', 'request', 'request_date'));
    }


    public function assignShiftForm($requestId)
    {
        // Client service request
        $request = \App\Models\Client\ServiceRequest::findOrFail($requestId);

        // Business ke workers + shifts + bookings
        $workers = \App\Models\Worker\Worker::with('user', 'shifts.bookings')
            ->where('business_id', auth()->user()->business->id)
            ->get();

        // Client ki deadline hi booking date hogi
        $request_date = $request->deadline;

        return view('business.workers.assign_shift', compact(
            'workers',
            'request',
            'request_date'
        ));
    }


    public function allShifts()
    {
        // Authenticated business id
        $businessId = auth()->user()->business->id;

        // Get workers with their shifts
        $workers = Worker::with('shifts')->where('business_id', $businessId)->get();

        // Return view
        return view('business.workers.all_shifts', compact('workers'));
    }

    // Store new shift
    public function storeShift(Request $request, $workerId)
    {
        $request->validate([
            'shift_start' => 'required|date_format:H:i',
            'shift_end'   => 'required|date_format:H:i|after:shift_start',
        ]);

        \App\Models\Worker\WorkerShift::create([
            'worker_id'   => $workerId,
            'shift_start' => $request->shift_start,
            'shift_end'   => $request->shift_end,
        ]);

        return redirect()->route('business.workers.shifts')
            ->with('success', 'Shift added successfully!');
    }

    // Assign shift to client request
    public function assignShift(Request $request)
    {
        $request->validate([
            'client_request_id' => 'required|exists:service_requests,id',
            'worker_shift_id' => 'required|exists:worker_shifts,id',
            'booking_date' => 'required|date',
        ]);

        // Check if already booked for this date
        $alreadyBooked = WorkerShiftBooking::where('worker_shift_id', $request->worker_shift_id)
            ->where('booking_date', $request->booking_date)
            ->exists();

        if ($alreadyBooked) {
            return redirect()->back()->with('error', 'This shift is already booked for the selected date.');
        }

        // Save booking
        WorkerShiftBooking::create([
            'client_request_id' => $request->client_request_id,
            'worker_shift_id' => $request->worker_shift_id,
            'booking_date' => $request->booking_date,
        ]);

        return redirect()->back()->with('success', 'Shift assigned successfully.');
    }
}
