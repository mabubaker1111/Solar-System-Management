<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewClientQuery extends Notification
{
    use Queueable;

    public $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    // Delivery channels: database for notifications
    public function via($notifiable)
    {
        return ['database'];
    }

    // Data stored in database notification
    public function toDatabase($notifiable)
    {
        return [
            'query_id' => $this->query->id,
            'message' => "New query from client #{$this->query->client_id}",
            'link' => route('business.query.show', $this->query->id),
        ];
    }
}
