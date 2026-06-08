<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicationNotification extends Notification
{
    public function __construct(public Application $application) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("New Application — {$this->application->internship->title}")
            ->greeting('Hello,')
            ->line("{$this->application->student->user->name} applied for {$this->application->internship->title}.")
            ->action('Review Application', route('company.applicants.show', [
                $this->application->internship,
                $this->application,
            ]))
            ->line('Log in to review the applicant\'s profile and documents.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title'   => 'New Application Received',
            'message' => "{$this->application->student->user->name} applied for {$this->application->internship->title}.",
            'data'    => [
                'application_id' => $this->application->id,
                'internship_id'  => $this->application->internship_id,
            ],
        ];
    }
}
