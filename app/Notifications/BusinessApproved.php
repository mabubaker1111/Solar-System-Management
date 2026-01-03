<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BusinessApproved extends Notification
{
    use Queueable;

    protected $business;

    public function __construct($business)
    {
        $this->business = $business;
    }

    public function via($notifiable)
    {
        return ['mail']; // Only email for now
    }

   public function toMail($notifiable)
{
    return (new MailMessage)
                ->subject('🎉 Your Business Has Been Approved!')
                ->greeting('Hello ' . $this->business->owner_name . ',')
                ->line('We are excited to inform you that your business, **"' . $this->business->name . '"**, has been officially approved by the Admin.')
                ->line('You can now manage your services, track requests, and connect with clients on our platform.')
                ->action('View Your Business', url('/client/business/' . $this->business->id))
                ->line('Thank you for trusting Us. We look forward to supporting your growth!');
}
}
