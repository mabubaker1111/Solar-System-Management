<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WorkerRequest extends Notification
{
    use Queueable;

    protected $worker;
    protected $business;

    public function __construct($worker, $business)
    {
        $this->worker = $worker;
        $this->business = $business;
    }

    // Email + database notification
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    // Email content
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Worker Registration Request')
                    ->greeting('Hello ' . $this->business->owner->name)
                    ->line('A new worker has registered and requested to join your business.')
                    ->line('plaese review the business and response them.')
                    ->line('Worker Name: ' . $this->worker->name)
                    ->line('Worker Email: ' . $this->worker->email)
                    ->action('View Worker Request', url('/business/dashboard/worker-requests'))
                    ->line('Please review the request in your dashboard.');
    }

    // Database notification
    public function toDatabase($notifiable)
    {
        return [
            'worker_id' => $this->worker->id,
            'worker_name' => $this->worker->name,
            'message' => 'A new worker requested to join your business.'
        ];
    }
}
