<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusChangedNotification extends Notification
{
    public function __construct(public Application $application) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Application Update — {$this->application->internship->title}")
            ->greeting("Hello {$this->application->student->user->name},")
            ->line("Your application status changed to: {$this->application->statusLabel()}")
            ->action('View Application', route('student.applications.show', $this->application))
            ->line('Log in to see any notes or next steps.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title'   => 'Application Status Updated',
            'message' => "Your application for '{$this->application->internship->title}' is now: {$this->application->statusLabel()}",
            'data'    => ['application_id' => $this->application->id],
        ];
    }
}
