<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InternshipClosedNotification extends Notification
{
    public function __construct(public Application $application) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Internship Closed — {$this->application->internship->title}")
            ->greeting("Hello {$this->application->student->user->name},")
            ->line("The internship '{$this->application->internship->title}' has been closed by {$this->application->internship->company->company_name}.")
            ->line('Your application has been retained but no further action is expected.')
            ->line('Keep exploring other opportunities on InternConnect.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title'   => 'Internship Closed',
            'message' => "'{$this->application->internship->title}' is no longer available.",
            'data'    => ['application_id' => $this->application->id],
        ];
    }
}
