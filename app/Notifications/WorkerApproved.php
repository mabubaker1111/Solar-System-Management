<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WorkerApproved extends Notification
{
    use Queueable;

    protected $worker;

    public function __construct($worker)
    {
        $this->worker = $worker;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Worker Registration is Approved')
            ->greeting('Hello ' . $this->worker->name)
            ->line('We are pleased to inform you that your registration request has been approved by the business.')
            ->action('Go to Dashboard', url('/worker/dashboard'))
            ->line('Thank you for being part of our platform! We look forward to your contributions!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Your registration request has been approved by the business.',
            'link'    => url('/worker/dashboard') // ya koi aur page jaha redirect karna ho
        ];
    }
}
