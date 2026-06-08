<?php

namespace App\Notifications;

use App\Models\CompanyProfile;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanySubmittedNotification extends Notification
{
    public function __construct(public CompanyProfile $company) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("New Company Registration — {$this->company->company_name}")
            ->greeting('Hello Admin,')
            ->line("{$this->company->company_name} has registered and submitted verification documents.")
            ->action('Review Company', route('admin.companies.show', $this->company))
            ->line('Please review their documents and verify or reject the registration.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title'   => 'New Company Registration',
            'message' => "{$this->company->company_name} submitted documents for verification.",
            'data'    => ['company_id' => $this->company->id],
        ];
    }
}
