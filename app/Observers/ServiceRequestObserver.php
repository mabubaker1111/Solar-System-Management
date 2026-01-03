<?php
namespace App\Observers;

use App\Models\Client\ServiceRequest;
use App\Notifications\DeadlineApproaching;
use App\Models\User;
use Carbon\Carbon;

class ServiceRequestObserver
{
    public function updated(ServiceRequest $request)
    {
        // Check if deadline is within 1 day and notification not sent yet
        $now = Carbon::now();
        $threshold = $now->copy()->addDay();

        if ($request->deadline <= $threshold && !$request->deadline_notified) {

            // Notify Business Owner
            if ($request->business && $request->business->owner) {
                $request->business->owner->notify(new DeadlineApproaching($request));
            }

            // Notify all Superadmins
            $superadmins = User::where('role', 'superadmin')->get();
            foreach ($superadmins as $admin) {
                $admin->notify(new DeadlineApproaching($request));
            }

            // Mark as notified
            $request->update(['deadline_notified' => true]);
        }
    }
}
