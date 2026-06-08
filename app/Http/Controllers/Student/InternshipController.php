<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\InternshipCategory;
use App\Models\SavedInternship;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InternshipController extends Controller
{
    public function index(Request $request): View
    {
        $query = Internship::with(['company', 'category'])
            ->approved();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('type')) {
            $query->where('internship_type', $request->type);
        }

        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'deadline'  => $query->orderBy('deadline'),
            'positions' => $query->orderByDesc('positions'),
            default     => $query->latest(),
        };

        $internships = $query->paginate(12)->withQueryString();
        $categories  = InternshipCategory::active()->get();

        // Get saved IDs for the current student
        $savedIds = collect();
        if ($profile = auth()->user()->studentProfile) {
            $savedIds = $profile->savedInternships()->pluck('internship_id');
        }

        return view('student.internships.index', compact('internships', 'categories', 'savedIds'));
    }

    public function show(Internship $internship): View
    {
        abort_if($internship->status !== 'approved', 404);

        $internship->load(['company.documents', 'category']);

        $profile    = auth()->user()->studentProfile;
        $hasApplied = $profile?->applications()->where('internship_id', $internship->id)->exists();
        $isSaved    = $profile?->savedInternships()->where('internship_id', $internship->id)->exists();

        return view('student.internships.show', compact('internship', 'hasApplied', 'isSaved'));
    }
}
