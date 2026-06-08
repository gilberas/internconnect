<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationCertificate;
use App\Models\Internship;
use App\Notifications\NewApplicationNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(): View
    {
        $profile = auth()->user()->studentProfile;
        $applications = $profile->applications()
            ->with(['internship.company', 'interview'])
            ->latest()
            ->get();

        return view('student.applications.index', compact('applications'));
    }

    public function show(Application $application): View
    {
        abort_if($application->student_id !== auth()->user()->studentProfile?->id, 403);
        $application->load(['internship.company', 'interview', 'certificates']);

        return view('student.applications.show', compact('application'));
    }

    public function store(Request $request, Internship $internship): RedirectResponse
    {
        $request->validate([
            'cv'              => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'cover_letter'    => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'certificates'    => ['nullable', 'array', 'max:5'],
            'certificates.*'  => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        $profile = auth()->user()->studentProfile;

        abort_if(! $internship->isOpen(), 403, 'This internship is not accepting applications.');

        if ($profile->applications()->where('internship_id', $internship->id)->exists()) {
            return back()->with('error', 'You have already applied to this internship.');
        }

        DB::transaction(function () use ($request, $internship, $profile) {
            $cvPath    = $request->hasFile('cv')
                ? $request->file('cv')->store("applications/{$profile->id}/cvs", 'private')
                : $profile->cv_path;

            $coverPath = $request->hasFile('cover_letter')
                ? $request->file('cover_letter')->store("applications/{$profile->id}/covers", 'private')
                : null;

            $application = Application::create([
                'internship_id'     => $internship->id,
                'student_id'        => $profile->id,
                'cv_path'           => $cvPath,
                'cover_letter_path' => $coverPath,
                'status'            => 'submitted',
            ]);

            if ($request->hasFile('certificates')) {
                foreach ($request->file('certificates') as $file) {
                    $path = $file->store("applications/{$profile->id}/certs", 'private');
                    ApplicationCertificate::create([
                        'application_id'    => $application->id,
                        'original_filename' => $file->getClientOriginalName(),
                        'file_path'         => $path,
                        'mime_type'         => $file->getMimeType(),
                    ]);
                }
            }
        });

        $application = Application::with(['student.user', 'internship'])
            ->where('internship_id', $internship->id)
            ->where('student_id', $profile->id)
            ->latest()
            ->first();

        $internship->loadMissing('company.user');
        $internship->company->user->notify(new NewApplicationNotification($application));

        return redirect()->route('student.applications.index')
            ->with('status', 'Application submitted! You will be notified of updates.');
    }
}
