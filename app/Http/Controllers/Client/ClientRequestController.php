<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Business\Service;
use App\Models\Client\ServiceRequest;
use App\Notifications\NewServiceRequest;
use Carbon\Carbon;

class ClientRequestController extends Controller
{
    // Show form
    public function create($service_id)
    {
        $service = Service::with('business')->findOrFail($service_id);
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->take(10)->get();
        $unreadCount = $user->unreadNotifications()->count();

        return view('client.request_service', compact('service', 'notifications', 'unreadCount'));
    }

    // Store request
    public function store(Request $request)
    {
        $request->validate([
            'service_id'  => 'required|exists:services,id',
            'business_id' => 'required|exists:businesses,id',
            'deadline'    => 'required|date|after:now',
            'notes'       => 'nullable|string',
        ]);

        $service = Service::findOrFail($request->service_id);

        $sr = ServiceRequest::create([
            'client_id'   => Auth::id(),
            'user_id'     => Auth::id(), 
            'service_id'  => $request->service_id,
            'business_id' => $request->business_id,
            'notes'       => $request->notes,
            'deadline'    => Carbon::parse($request->deadline),
            'price'       => $service->price,
            'date'        => now()->toDateString(),
            'time'        => now()->toTimeString(),
            'status'      => 'pending',
        ]);


        // Notify business owner
        $sr->business->owner->notify(new NewServiceRequest($sr));

        return redirect()->route('client.requests')->with('success', 'Service request sent with deadline!');
    }
}
