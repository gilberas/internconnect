<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Internship;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicantController extends Controller
{
    private function companyProfile()
    {
        return auth()->user()->companyProfile;
    }

    public function index(Internship $internship): View
    {
        abort_if($internship->company_id !== $this->companyProfile()->id, 403);

        $applications = $internship->applications()
            ->with(['student.user', 'interview'])
            ->latest()
            ->paginate(15);

        return view('company.applicants.index', compact('internship', 'applications'));
    }

    public function show(Internship $internship, Application $application): View
    {
        abort_if($internship->company_id !== $this->companyProfile()->id, 403);
        abort_if($application->internship_id !== $internship->id, 404);

        $application->load(['student.user', 'interview', 'certificates']);

        return view('company.applicants.show', compact('internship', 'application'));
    }

    public function updateStatus(Application $application, Request $request): RedirectResponse
    {
        $internship = $application->internship;
        abort_if($internship->company_id !== $this->companyProfile()->id, 403);

        $data = $request->validate([
            'status'        => ['required', 'in:under_review,shortlisted,accepted,rejected'],
            'company_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $application->update($data);

        return back()->with('status', 'Application status updated.');
    }
}
