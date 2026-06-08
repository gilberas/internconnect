<?php

namespace App\Notifications;

use App\Models\Interview;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InterviewRescheduledNotification extends Notification
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
            ->subject("Interview Rescheduled — {$app->internship->title}")
            ->greeting("Hello {$app->student->user->name},")
            ->line('Your interview has been rescheduled.')
            ->line("New Date: {$this->interview->interview_date->format('l, d M Y')}")
            ->line("New Time: {$this->interview->interview_time}")
            ->action('View Details', route('student.applications.show', $app))
            ->line('Please update your calendar accordingly.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title'   => 'Interview Rescheduled',
            'message' => "New time: {$this->interview->interview_date->format('d M Y')} at {$this->interview->interview_time}.",
            'data'    => [
                'interview_id'   => $this->interview->id,
                'application_id' => $this->interview->application_id,
            ],
        ];
    }
}
