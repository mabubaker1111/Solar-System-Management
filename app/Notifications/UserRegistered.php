<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserRegistered extends Notification
{
    use Queueable;

    protected $user;

    // User instance pass karenge constructor me
    public function __construct($user)
    {
        $this->user = $user;
    }

    // Channels (database + optional mail)
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    // Email content
    public function toMail($notifiable)
    {
        $subject = 'Welcome to Our System';

        $greeting = match ($this->user->role) {
            'client' => 'Hello Client ' . $this->user->name,
            'worker' => 'Hello Worker ' . $this->user->name,
            'business' => 'Hello Business ' . $this->user->name,
            'superadmin' => 'Hello Superadmin ' . $this->user->name,
            default => 'Hello ' . $this->user->name,
        };

        return (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line('Thank you for joining our platform.')
            ->line('Explore our platform and start your journey with us.')
            ->action('Visit Dashboard', url('/dashboard'))
            ->line('We are excited to have you!');
    }

    // Database content
    public function toDatabase($notifiable)
    {
        $message = match ($this->user->role) {
            'client' => 'Welcome Client ' . $this->user->name,
            'worker' => 'Welcome Worker ' . $this->user->name,
            'business' => 'Welcome Business ' . $this->user->name,
            'superadmin' => 'Welcome Superadmin ' . $this->user->name,
            default => 'Welcome ' . $this->user->name,
        };

        return [
            'message' => $message,
            'link' => url('/dashboard'),
        ];
    }
    public function toArray($notifiable)
    {
        return [
            'message' => 'Welcome ' . $this->user->name . '! Your account has been created.',
            'link'    => '/dashboard', // adjust based on role
        ];
    }
}
