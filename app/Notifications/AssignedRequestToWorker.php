<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Client\ServiceRequest;

class AssignedRequestToWorker extends Notification implements ShouldQueue
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
        $clientName = $this->request->client->name ?? 'Client';
        $service = $this->request->service->name ?? 'Service';

        return (new MailMessage)
            ->subject('New Assigned Request')
            ->greeting("Hello {$notifiable->name},")
            ->line("You have been assigned to a {$service} request by {$this->request->business->business_name}.")
            ->line("Client: {$clientName}")
            ->action('View Assigned Requests', url(route('worker.assigned.requests')))
            ->line('Please contact the client to coordinate.');
    }

    public function toArray($notifiable)
    {
        return [
            'sr_id' => $this->request->id,
            'message' => 'You were assigned to a request',
            'link' => route('worker.assigned.requests'),
        ];
    }
}
