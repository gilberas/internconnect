<?php

namespace App\Notifications;

use App\Models\Internship;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InternshipSubmittedNotification extends Notification
{
    public function __construct(public Internship $internship) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("New Internship Pending Review — {$this->internship->title}")
            ->greeting('Hello Admin,')
            ->line("{$this->internship->company->company_name} submitted a new internship for review.")
            ->action('Review Internship', route('admin.internships.show', $this->internship))
            ->line('Please review and approve or reject this listing.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title'   => 'Internship Pending Review',
            'message' => "{$this->internship->title} by {$this->internship->company->company_name} needs approval.",
            'data'    => ['internship_id' => $this->internship->id],
        ];
    }
}
