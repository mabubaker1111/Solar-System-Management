<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Client\ServiceRequest;

class DeadlineApproaching extends Notification implements ShouldQueue
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
    public function toDatabase($notifiable)
    {
        return [
            'message' => "Request #{$this->request->id} deadline is near!",
            'request_id' => $this->request->id,
            'deadline' => $this->request->deadline,
        ];
    }

    /**
     * Notification for email.
     */
public function toMail($notifiable)
{
    $clientName = $this->request->client->name ?? 'Unknown Client';

    return (new MailMessage)
        ->subject('Request Deadline Approaching')
        ->line("Attention: The service request from **{$clientName}** is approaching its deadline on **{$this->request->deadline}**. Please review and take necessary action.")
        ->action('View Request', url('/admin/requests/' . $this->request->id));
}


    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'request_id' => $this->request->id,
            'deadline'   => $this->request->deadline,
        ];
    }
}
