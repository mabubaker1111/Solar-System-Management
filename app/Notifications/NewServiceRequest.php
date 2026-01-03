<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Client\ServiceRequest;

class NewServiceRequest extends Notification implements ShouldQueue
{
    use Queueable;

    public $request;

    /**
     * Create a new notification instance.
     */
    public function __construct(ServiceRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Notification for database.
     */
    public function toMail($notifiable)
    {
        $clientName = $this->request->client->name ?? 'Unknown Client'; // Null safe

        return (new MailMessage)
            ->subject('New Service Request Received')
            ->line("You have received a new service request from **{$clientName}**.")
            ->action('View Request', url('/business/requests/' . $this->request->id))
            ->line('Please review the request and take the necessary action.');
    }

    public function toDatabase($notifiable)
    {
        $clientName = $this->request->client->name ?? 'Unknown Client';

        return [
            'message' => "New service request from {$clientName}",
            'request_id' => $this->request->id,
        ];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'request_id' => $this->request->id,
            'client' => $this->request->client->name,
            'service' => $this->request->service->name,
        ];
    }
}
