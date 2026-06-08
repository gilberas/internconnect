<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StudentShortlistedNotification extends Notification
{
    public function __construct(public Application $application) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("You've Been Shortlisted! — {$this->application->internship->title}")
            ->greeting('Congratulations!')
            ->line("You have been shortlisted for {$this->application->internship->title} at {$this->application->internship->company->company_name}.")
            ->action('View Application', route('student.applications.show', $this->application))
            ->line('Stay tuned — an interview invitation may follow.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title'   => "You're Shortlisted! 🎉",
            'message' => "Shortlisted for '{$this->application->internship->title}'.",
            'data'    => ['application_id' => $this->application->id],
        ];
    }
}
