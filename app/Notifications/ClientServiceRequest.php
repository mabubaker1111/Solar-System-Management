<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Client\ServiceRequest;

class ClientServiceRequest extends Notification
{
    use Queueable;

    protected $request;

    public function __construct(ServiceRequest $request)
    {
        $this->request = $request;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; // database + email notification
    }

   public function toMail($notifiable)
{
    return (new MailMessage)
                ->subject(' New Service Request Received')
                ->greeting('Hello ' . $this->request->business->owner_name . ',')
                ->line('You have received a new service request from a client on the platform.')
                ->line('**Client Name:** ' . $this->request->client->name)
                ->line('**Service Requested:** ' . $this->request->service->name)
                ->line('Please review the request and take appropriate action.')
                ->action('View Request', url('/business/client-requests'))
                ->line('Thank you for using Us, we appreciate your prompt attention!');
}


    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->request->client->name . ' requested ' . $this->request->service->name,
            'link'    => url('/business/client-requests')
        ];
    }
}
