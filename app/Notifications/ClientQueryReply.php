<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ClientQueryReply extends Notification
{
    use Queueable;

    public $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'query_id' => $this->query->id,
            'message' => "Reply from business: " . $this->query->response,
            'link' => route('client.query.show', $this->query->id),
        ];
    }
}
