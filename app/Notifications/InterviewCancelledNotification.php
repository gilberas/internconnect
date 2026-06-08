<?php

namespace App\Notifications;

use App\Models\Interview;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InterviewCancelledNotification extends Notification
{
    public function __construct(public Interview $interview) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $app = $this->interview->application;

        return (new MailMessage)
            ->subject("Interview Cancelled — {$app->internship->title}")
            ->greeting("Hello {$app->student->user->name},")
            ->line("Your interview for {$app->internship->title} was cancelled.")
            ->line('The company may reschedule. Check your application for updates.')
            ->action('View Application', route('student.applications.show', $app))
            ->line('We apologise for any inconvenience.');
    }

    public function toDatabase(object $notifiable): array
    {
        $app = $this->interview->application;

        return [
            'title'   => 'Interview Cancelled',
            'message' => "Interview for '{$app->internship->title}' was cancelled.",
            'data'    => [
                'interview_id'   => $this->interview->id,
                'application_id' => $app->id,
            ],
        ];
    }
}
