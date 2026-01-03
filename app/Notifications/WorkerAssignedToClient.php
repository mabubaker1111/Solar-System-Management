<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Client\ServiceRequest;

class WorkerAssignedToClient extends Notification implements ShouldQueue
{
    use Queueable;

    protected $request;

    public function __construct(ServiceRequest $request)
    {
        $this->request = $request;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; // mail optional
    }

    public function toMail($notifiable)
    {
        $workerName = $this->request->worker->user->name ?? 'Worker';
        $service = $this->request->service->name ?? 'Service';

        return (new MailMessage)
            ->subject('Worker Assigned to Your Request')
            ->greeting("Hello {$notifiable->name},")
            ->line("A worker ({$workerName}) has been assigned to your {$service} request to solve your issue.")
            ->action('View My Requests', url(route('client.requests')))
            ->line('If you need to contact the worker, details are shown in My Requests.')
            ->line('Thank you for trusting on us.');
    }

    public function toArray($notifiable)
    {
        return [
            'sr_id' => $this->request->id,
            'message' => 'A worker has been assigned to your request',
            'link' => route('client.requests'),
        ];
    }
}
