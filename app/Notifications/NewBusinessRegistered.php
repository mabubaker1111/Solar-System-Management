<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Business\Business;

class NewBusinessRegistered extends Notification implements ShouldQueue
{
    use Queueable;

    protected $business;

    public function __construct(Business $business)
    {
        $this->business = $business;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // email + dashboard
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Business Registered')
            ->greeting('Hello Admin,')
            ->line("A new business '{$this->business->business_name}' has been registered on the platform.")
            ->action('View Business', url(route('superadmin.business.view', $this->business->id)))
            ->line('Kindly review the details and take appropriate action.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'business_id' => $this->business->id,
            'message'     => "New business '{$this->business->business_name}' has been registered.",
            'link'        => route('superadmin.business.view', $this->business->id),
        ];
    }
}
