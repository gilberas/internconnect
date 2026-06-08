<?php

namespace App\Notifications;

use App\Models\Internship;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InternshipApprovedNotification extends Notification
{
    public function __construct(public Internship $internship) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Internship Approved — {$this->internship->title}")
            ->greeting('Great news!')
            ->line("Your internship '{$this->internship->title}' has been approved and is now live.")
            ->action('View Internship', route('company.internships.show', $this->internship))
            ->line('Students can now find and apply to your listing.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title'   => 'Internship Approved ✓',
            'message' => "'{$this->internship->title}' is now live and accepting applications.",
            'data'    => ['internship_id' => $this->internship->id],
        ];
    }
}
