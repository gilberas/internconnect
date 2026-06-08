<?php

namespace App\Notifications;

use App\Models\CompanyProfile;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyRejectedNotification extends Notification
{
    public function __construct(public CompanyProfile $company) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Company Verification Update — InternConnect')
            ->greeting("Hello {$this->company->company_name},")
            ->line('Your verification was not approved.')
            ->line("Reason: {$this->company->rejection_reason}")
            ->line('Please resubmit with corrected documents.')
            ->action('Resubmit Documents', route('company.setup'))
            ->line('Contact support if you need assistance.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title'   => 'Verification Rejected',
            'message' => "Reason: {$this->company->rejection_reason}",
            'data'    => ['company_id' => $this->company->id],
        ];
    }
}
