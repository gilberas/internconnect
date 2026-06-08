<?php

namespace App\Notifications;

use App\Models\Internship;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InternshipRejectedNotification extends Notification
{
    public function __construct(public Internship $internship) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Internship Review Update — {$this->internship->title}")
            ->greeting('Hello,')
            ->line("Your internship '{$this->internship->title}' was not approved.")
            ->line("Reason: {$this->internship->rejection_reason}")
            ->action('Edit and Resubmit', route('company.internships.edit', $this->internship))
            ->line('Please address the feedback and resubmit for review.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title'   => 'Internship Rejected',
            'message' => "'{$this->internship->title}' rejected. Reason: {$this->internship->rejection_reason}",
            'data'    => ['internship_id' => $this->internship->id],
        ];
    }
}
