<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Interview;
use App\Notifications\InterviewCancelledNotification;
use App\Notifications\InterviewRescheduledNotification;
use App\Notifications\InterviewScheduledNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    private function companyProfile()
    {
        return auth()->user()->companyProfile;
    }

    public function store(Application $application, Request $request): RedirectResponse
    {
        abort_if($application->internship->company_id !== $this->companyProfile()->id, 403);

        $data = $request->validate([
            'interview_date' => ['required', 'date', 'after:today'],
            'interview_time' => ['required', 'date_format:H:i'],
            'interview_type' => ['required', 'in:physical,online,phone'],
            'venue'          => ['required_if:interview_type,physical', 'nullable', 'string', 'max:255'],
            'meeting_link'   => ['required_if:interview_type,online', 'nullable', 'url', 'max:500'],
            'instructions'   => ['nullable', 'string', 'max:1000'],
        ]);

        $interview = Interview::create(['application_id' => $application->id, 'status' => 'scheduled'] + $data);
        $application->update(['status' => 'interview_scheduled']);
        $interview->load(['application.student.user', 'application.internship']);

        $application->student->user->notify(new InterviewScheduledNotification($interview));

        return back()->with('status', 'Interview scheduled. Student has been notified.');
    }

    public function update(Interview $interview, Request $request): RedirectResponse
    {
        abort_if($interview->application->internship->company_id !== $this->companyProfile()->id, 403);

        $data = $request->validate([
            'interview_date' => ['required', 'date', 'after:today'],
            'interview_time' => ['required', 'date_format:H:i'],
            'interview_type' => ['required', 'in:physical,online,phone'],
            'venue'          => ['required_if:interview_type,physical', 'nullable', 'string', 'max:255'],
            'meeting_link'   => ['required_if:interview_type,online', 'nullable', 'url', 'max:500'],
            'instructions'   => ['nullable', 'string', 'max:1000'],
        ]);

        // Log reschedule history
        $history   = $interview->reschedule_history ?? [];
        $history[] = [
            'previous_date' => $interview->interview_date,
            'previous_time' => $interview->interview_time,
            'rescheduled_at'=> now()->toDateTimeString(),
        ];

        $interview->update($data + ['status' => 'rescheduled', 'reschedule_history' => $history]);
        $interview->load(['application.student.user', 'application.internship']);

        $interview->application->student->user->notify(new InterviewRescheduledNotification($interview));

        return back()->with('status', 'Interview rescheduled. Student has been notified.');
    }

    public function cancel(Interview $interview): RedirectResponse
    {
        abort_if($interview->application->internship->company_id !== $this->companyProfile()->id, 403);
        $interview->load(['application.student.user', 'application.internship']);
        $interview->update(['status' => 'cancelled']);

        $interview->application->student->user->notify(new InterviewCancelledNotification($interview));

        return back()->with('status', 'Interview cancelled. Student has been notified.');
    }
}
