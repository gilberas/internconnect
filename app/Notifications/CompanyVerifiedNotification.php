<?php

namespace App\Notifications;

use App\Models\CompanyProfile;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyVerifiedNotification extends Notification
{
    public function __construct(public CompanyProfile $company) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Company Has Been Verified — InternConnect')
            ->greeting("Great news, {$this->company->company_name}!")
            ->line('Your company has been verified. You can now post internship listings.')
            ->action('Post Your First Internship', route('company.internships.create'))
            ->line('Thank you for joining InternConnect.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title'   => 'Company Verified ✓',
            'message' => 'Your company is verified. Start posting internships now.',
            'data'    => ['company_id' => $this->company->id],
        ];
    }
}
