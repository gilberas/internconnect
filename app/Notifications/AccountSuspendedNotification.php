<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountSuspendedNotification extends Notification
{
    public function __construct(public User $user) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Account Suspended — InternConnect')
            ->greeting("Hello {$this->user->name},")
            ->line('Your InternConnect account has been suspended.')
            ->line("Reason: {$this->user->suspended_reason}")
            ->line('Contact support@internconnect.co.tz to appeal.')
            ->line('We take community guidelines seriously and appreciate your understanding.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title'   => 'Account Suspended',
            'message' => "Your account was suspended. Reason: {$this->user->suspended_reason}",
            'data'    => ['user_id' => $this->user->id],
        ];
    }
}
