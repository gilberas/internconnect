<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\InternshipCategory;
use App\Models\User;
use App\Notifications\InternshipClosedNotification;
use App\Notifications\InternshipSubmittedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InternshipController extends Controller
{
    private function companyProfile()
    {
        return auth()->user()->companyProfile;
    }

    private function validationRules(): array
    {
        return [
            'title'            => ['required', 'string', 'max:255'],
            'category_id'      => ['required', 'exists:internship_categories,id'],
            'description'      => ['required', 'string', 'min:50'],
            'requirements'     => ['required', 'string'],
            'responsibilities' => ['required', 'string'],
            'skills_required'  => ['nullable', 'string'],
            'positions'        => ['required', 'integer', 'min:1', 'max:100'],
            'location'         => ['required', 'string', 'max:255'],
            'duration'         => ['required', 'string', 'max:100'],
            'internship_type'  => ['required', 'in:full_time,part_time,remote'],
            'deadline'         => ['required', 'date', 'after:today'],
        ];
    }

    private function processSkills(Request $request): array
    {
        return array_values(array_filter(
            array_map('trim', explode(',', $request->skills_required ?? ''))
        ));
    }

    public function index(Request $request): View
    {
        $query = $this->companyProfile()->internships()->with('category')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $internships = $query->paginate(10)->withQueryString();

        return view('company.internships.index', compact('internships'));
    }

    public function create(): View
    {
        abort_if(! $this->companyProfile()?->isVerified(), 403,
            'Your company must be verified before posting internships.');

        $categories = InternshipCategory::where('is_active', true)->orderBy('name')->get();
        return view('company.internships.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->validationRules());
        $data['skills_required'] = $this->processSkills($request);
        $data['company_id']      = $this->companyProfile()->id;
        $data['status']          = 'pending';

        $internship = Internship::create($data);
        $internship->load('company');

        User::where('account_type', 'admin')->each(
            fn ($admin) => $admin->notify(new InternshipSubmittedNotification($internship))
        );

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

        $categories = InternshipCategory::where('is_active', true)->orderBy('name')->get();
        return view('company.internships.edit', compact('internship', 'categories'));
    }

    public function update(Request $request, Internship $internship): RedirectResponse
    {
        abort_if($internship->company_id !== $this->companyProfile()->id, 403);
        abort_if(! $internship->isEditable(), 403, 'Only pending or rejected internships can be edited.');

        $data = $request->validate($this->validationRules());
        $data['skills_required']  = $this->processSkills($request);
        $data['status']           = 'pending';
        $data['rejection_reason'] = null;

        $internship->update($data);

        return redirect()->route('company.internships.index')
            ->with('status', 'Internship updated and resubmitted for review.');
    }

    public function destroy(Internship $internship): RedirectResponse
    {
        abort_if($internship->company_id !== $this->companyProfile()->id, 403);
        abort_if(
            ! in_array($internship->status, ['pending', 'rejected']),
            403, 'Only pending or rejected internships can be deleted.'
        );

        $internship->delete();

        return redirect()->route('company.internships.index')
            ->with('status', 'Internship deleted.');
    }

    public function close(Internship $internship): RedirectResponse
    {
        abort_if($internship->company_id !== $this->companyProfile()->id, 403);
        $internship->update(['status' => 'closed']);

        $internship->applications()->with('student.user', 'internship.company')->get()->each(
            fn ($app) => $app->student->user->notify(new InternshipClosedNotification($app))
        );

        return back()->with('status', 'Internship closed.');
    }
}
