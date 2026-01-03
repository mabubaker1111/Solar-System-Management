<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Client\ServiceRequest; // <- correct model
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WorkerCancelledRequest extends Notification
{
    use Queueable;

    public $request;

    // ✅ Type hint matches the model
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
            'message' => "Worker cancelled the request: " . $this->request->id,
            'request_id' => $this->request->id,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Request Cancelled by Worker')
            ->line("Worker has cancelled request ID: " . $this->request->id)
            ->action('View Request', url('/business/requests/' . $this->request->id));
    }
}
