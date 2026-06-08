<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Internship;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InternshipController extends Controller
{
    public function index(Request $request): View
    {
        $query = Internship::with(['company', 'category'])->withCount('applications')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $internships = $query->paginate(15)->withQueryString();

        $counts = [
            'total'    => Internship::count(),
            'pending'  => Internship::where('status', 'pending')->count(),
            'approved' => Internship::where('status', 'approved')->count(),
            'rejected' => Internship::where('status', 'rejected')->count(),
            'closed'   => Internship::where('status', 'closed')->count(),
        ];

        return view('admin.internships.index', compact('internships', 'counts'));
    }

    public function show(Internship $internship): View
    {
        $internship->load(['company', 'category', 'applications']);
        return view('admin.internships.show', compact('internship'));
    }

    public function approve(Internship $internship): RedirectResponse
    {
        $internship->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        ActivityLog::record('approve_internship', auth()->user(), $internship);

        return back()->with('status', "Internship '{$internship->title}' approved and published.");
    }

    public function reject(Internship $internship, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'rejection_reason' => ['required', 'string', 'min:10', 'max:500'],
        ]);

        $internship->update([
            'status'           => 'rejected',
            'rejection_reason' => $data['rejection_reason'],
        ]);

        ActivityLog::record('reject_internship', auth()->user(), $internship);

        return back()->with('status', 'Internship rejected. Company notified.');
    }
}
