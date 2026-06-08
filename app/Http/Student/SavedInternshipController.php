<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\SavedInternship;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SavedInternshipController extends Controller
{
    public function index(): View
    {
        $profile = auth()->user()->studentProfile;
        $saved   = $profile->savedInternships()
            ->with('internship.company', 'internship.category')
            ->latest()
            ->paginate(12);

        return view('student.saved.index', compact('saved'));
    }

    public function toggle(Internship $internship): JsonResponse|RedirectResponse
    {
        $profile = auth()->user()->studentProfile;
        $existing = SavedInternship::where('student_id', $profile->id)
            ->where('internship_id', $internship->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $saved = false;
        } else {
            SavedInternship::create(['student_id' => $profile->id, 'internship_id' => $internship->id]);
            $saved = true;
        }

        if (request()->wantsJson()) {
            return response()->json(['saved' => $saved]);
        }

        return back()->with('status', $saved ? 'Internship saved.' : 'Internship removed from saved.');
    }
}
