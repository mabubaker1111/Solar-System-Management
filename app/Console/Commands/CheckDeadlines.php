<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Client\ServiceRequest;
use App\Models\User;
use App\Notifications\DeadlineApproaching;
use Carbon\Carbon;

class CheckDeadlines extends Command
{
    protected $signature = 'app:check-deadlines';
    protected $description = 'Check service requests deadlines and notify business & superadmin';

    public function handle()
    {
        $now = Carbon::now();

        // Threshold: 1 day before deadline
        $threshold = $now->copy()->addDay(); 

        // Fetch requests whose deadline is approaching and not yet notified
        $requests = ServiceRequest::where('deadline', '<=', $threshold)
            ->where('deadline_notified', false)
            ->get();

        foreach ($requests as $request) {

            // Notify business owner
            if ($request->business && $request->business->owner) {
                $request->business->owner->notify(new DeadlineApproaching($request));
            }

            // Notify all superadmins
            $superadmins = User::where('role', 'superadmin')->get();
            foreach ($superadmins as $admin) {
                $admin->notify(new DeadlineApproaching($request));
            }

            // Mark as notified
            $request->update(['deadline_notified' => true]);
        }

        $this->info('Deadline notifications sent successfully!');
    }
}
