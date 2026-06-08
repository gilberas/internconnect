<?php

namespace App\Notifications;

use App\Models\Interview;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InterviewScheduledNotification extends Notification
{
    public function __construct(public Interview $interview) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $app = $this->interview->application;

        $mail = (new MailMessage)
            ->subject("Interview Scheduled — {$app->internship->title}")
            ->greeting("Hello {$app->student->user->name},")
            ->line('An interview has been scheduled for your application.')
            ->line("Date: {$this->interview->interview_date->format('l, d M Y')}")
            ->line("Time: {$this->interview->interview_time}")
            ->line("Type: {$this->interview->typeLabel()}");

        if ($this->interview->venue) {
            $mail->line("Venue: {$this->interview->venue}");
        } elseif ($this->interview->meeting_link) {
            $mail->line("Link: {$this->interview->meeting_link}");
        }

        return $mail
            ->action('View Details', route('student.applications.show', $app))
            ->line('Good luck with your interview!');
    }

    public function toDatabase(object $notifiable): array
    {
        $app = $this->interview->application;

        return [
            'title'   => 'Interview Scheduled 📅',
            'message' => "Interview for '{$app->internship->title}' on {$this->interview->interview_date->format('d M Y')} at {$this->interview->interview_time}.",
            'data'    => [
                'interview_id'   => $this->interview->id,
                'application_id' => $app->id,
            ],
        ];
    }
}
