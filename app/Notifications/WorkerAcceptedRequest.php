<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Client\ServiceRequest; // <- correct namespace
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WorkerAcceptedRequest extends Notification
{
    use Queueable;

    public $request;

    // Correct type hint
    public function __construct(ServiceRequest $request)
    {
        $this->request = $request;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Worker accepted request ID: " . $this->request->id,
            'request_id' => $this->request->id,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Request Accepted by Worker')
            ->line("Worker has accepted request ID: " . $this->request->id)
            ->action('View Request', url('/business/requests/' . $this->request->id));
            
    }
}
