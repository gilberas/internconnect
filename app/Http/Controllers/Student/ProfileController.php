<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function setup(): View
    {
        $profile = auth()->user()->studentProfile;
        return view('student.profile.setup', compact('profile'));
    }

    public function edit(): View
    {
        $profile = auth()->user()->studentProfile;
        return view('student.profile.edit', compact('profile'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'full_name'       => ['required', 'string', 'max:255'],
            'gender'          => ['nullable', 'in:male,female,other'],
            'date_of_birth'   => ['nullable', 'date', 'before:today'],
            'phone'           => ['nullable', 'string', 'max:20'],
            'university'      => ['required', 'string', 'max:255'],
            'program'         => ['required', 'string', 'max:255'],
            'graduation_year' => ['required', 'integer', 'min:2000', 'max:2035'],
            'skills'          => ['nullable', 'array'],
            'skills.*'        => ['string', 'max:100'],
        ]);

        $profile = auth()->user()->studentProfile;
        $profile->update($data);
        $profile->calculateCompletionPercentage();

        return redirect()->route('student.profile.edit')
            ->with('status', 'Profile updated successfully.');
    }

    public function uploadCv(Request $request): RedirectResponse
    {
        $request->validate(['cv' => ['required', 'file', 'mimes:pdf', 'max:5120']]);

        $profile = auth()->user()->studentProfile;

        if ($profile->cv_path) {
            Storage::delete($profile->cv_path);
        }

        $path = $request->file('cv')->store('student/cvs', 'private');
        $profile->update(['cv_path' => $path]);
        $profile->calculateCompletionPercentage();

        return back()->with('status', 'CV uploaded successfully.');
    }

    public function uploadPhoto(Request $request): RedirectResponse
    {
        $request->validate(['photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048']]);

        $profile = auth()->user()->studentProfile;

        if ($profile->profile_photo_path) {
            Storage::delete($profile->profile_photo_path);
        }

        $path = $request->file('photo')->store('student/photos', 'public');
        $profile->update(['profile_photo_path' => $path]);
        $profile->calculateCompletionPercentage();

        return back()->with('status', 'Photo updated successfully.');
    }
}
