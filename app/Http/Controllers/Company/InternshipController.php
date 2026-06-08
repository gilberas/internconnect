<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreInternshipRequest;
use App\Models\Internship;
use App\Models\InternshipCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InternshipController extends Controller
{
    private function companyProfile()
    {
        return auth()->user()->companyProfile;
    }

    public function index(): View
    {
        $internships = $this->companyProfile()
            ->internships()
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('company.internships.index', compact('internships'));
    }

    public function create(): View
    {
        abort_if(! $this->companyProfile()?->isVerified(), 403,
            'Your company must be verified before posting internships.');

        $categories = InternshipCategory::active()->get();
        return view('company.internships.create', compact('categories'));
    }

    public function store(StoreInternshipRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['company_id'] = $this->companyProfile()->id;
        $data['status']     = 'pending';

        Internship::create($data);

        return redirect()->route('company.internships.index')
            ->with('status', 'Internship submitted for review. You will be notified once approved.');
    }

    public function show(Internship $internship): View
    {
        abort_if($internship->company_id !== $this->companyProfile()->id, 403);
        $internship->load(['category', 'applications.student.user']);

        return view('company.internships.show', compact('internship'));
    }

    public function edit(Internship $internship): View
    {
        abort_if($internship->company_id !== $this->companyProfile()->id, 403);
        abort_if(! $internship->isEditable(), 403, 'Only pending or rejected internships can be edited.');

        $categories = InternshipCategory::active()->get();
        return view('company.internships.edit', compact('internship', 'categories'));
    }

    public function update(StoreInternshipRequest $request, Internship $internship): RedirectResponse
    {
        abort_if($internship->company_id !== $this->companyProfile()->id, 403);
        abort_if(! $internship->isEditable(), 403);

        $internship->update($request->validated() + ['status' => 'pending']);

        return redirect()->route('company.internships.index')
            ->with('status', 'Internship updated and resubmitted for review.');
    }

    public function destroy(Internship $internship): RedirectResponse
    {
        abort_if($internship->company_id !== $this->companyProfile()->id, 403);
        $internship->delete();

        return redirect()->route('company.internships.index')
            ->with('status', 'Internship deleted.');
    }

    public function close(Internship $internship): RedirectResponse
    {
        abort_if($internship->company_id !== $this->companyProfile()->id, 403);
        $internship->update(['status' => 'closed']);

        return back()->with('status', 'Internship closed. Existing applicants have been notified.');
    }
}
