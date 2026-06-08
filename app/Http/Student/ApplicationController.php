<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\ApplyRequest;
use App\Models\Application;
use App\Models\ApplicationCertificate;
use App\Models\Internship;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

    public function store(ApplyRequest $request, Internship $internship): RedirectResponse
    {
        $profile = auth()->user()->studentProfile;

        abort_if(! $internship->isOpen(), 403, 'This internship is no longer accepting applications.');

        $already = $profile->applications()->where('internship_id', $internship->id)->exists();
        if ($already) {
            return back()->with('error', 'You have already applied to this internship.');
        }

        DB::transaction(function () use ($request, $internship, $profile) {
            // Use uploaded CV or fall back to profile CV
            $cvPath = $request->hasFile('cv_path')
                ? $request->file('cv_path')->store("applications/{$profile->id}/cvs", 'private')
                : $profile->cv_path;

            $coverPath = $request->hasFile('cover_letter_path')
                ? $request->file('cover_letter_path')->store("applications/{$profile->id}/covers", 'private')
                : null;

            $application = Application::create([
                'internship_id'     => $internship->id,
                'student_id'        => $profile->id,
                'cv_path'           => $cvPath,
                'cover_letter_path' => $coverPath,
                'status'            => 'submitted',
            ]);

            // Upload certificates
            if ($request->hasFile('certificates')) {
                foreach ($request->file('certificates') as $file) {
                    $path = $file->store("applications/{$profile->id}/certs", 'private');
                    ApplicationCertificate::create([
                        'application_id'   => $application->id,
                        'original_filename'=> $file->getClientOriginalName(),
                        'file_path'        => $path,
                        'mime_type'        => $file->getMimeType(),
                    ]);
                }
            }
        });

        return redirect()->route('student.applications.index')
            ->with('status', 'Application submitted successfully! We will notify you of any updates.');
    }
}
