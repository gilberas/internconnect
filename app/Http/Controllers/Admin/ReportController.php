<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\CompanyProfile;
use App\Models\Internship;
use App\Models\InternshipCategory;
use App\Models\Interview;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $from = $request->from_date ?? now()->subMonths(6)->toDateString();
        $to   = $request->to_date   ?? now()->toDateString();

        $students = [
            'total'      => User::where('account_type', 'student')->count(),
            'this_month' => User::where('account_type', 'student')
                ->whereMonth('created_at', now()->month)->count(),
            'by_month'   => User::where('account_type', 'student')
                ->whereBetween('created_at', [$from, $to])
                ->selectRaw('DATE_FORMAT(created_at,"%b %Y") as month, COUNT(*) as count')
                ->groupBy('month', 'created_at')
                ->orderBy('created_at')
                ->get(),
        ];

        $companies = [
            'total'    => CompanyProfile::count(),
            'verified' => CompanyProfile::where('verification_status', 'verified')->count(),
            'pending'  => CompanyProfile::where('verification_status', 'pending')->count(),
            'rejected' => CompanyProfile::where('verification_status', 'rejected')->count(),
        ];

        $internships = [
            'total'       => Internship::count(),
            'approved'    => Internship::where('status', 'approved')->count(),
            'pending'     => Internship::where('status', 'pending')->count(),
            'closed'      => Internship::where('status', 'closed')->count(),
            'by_category' => InternshipCategory::withCount('internships')
                ->orderByDesc('internships_count')->get(),
        ];

        $applications = [
            'total'     => Application::count(),
            'submitted' => Application::where('status', 'submitted')->count(),
            'accepted'  => Application::where('status', 'accepted')->count(),
            'rejected'  => Application::where('status', 'rejected')->count(),
            'by_month'  => Application::whereBetween('created_at', [$from, $to])
                ->selectRaw('DATE_FORMAT(created_at,"%b %Y") as month, COUNT(*) as count')
                ->groupBy('month', 'created_at')
                ->orderBy('created_at')
                ->get(),
        ];

        $interviews = [
            'total'     => Interview::count(),
            'completed' => Interview::where('status', 'completed')->count(),
            'cancelled' => Interview::where('status', 'cancelled')->count(),
            'physical'  => Interview::where('interview_type', 'physical')->count(),
            'online'    => Interview::where('interview_type', 'online')->count(),
            'phone'     => Interview::where('interview_type', 'phone')->count(),
        ];

        return view('admin.reports.index',
            compact('students', 'companies', 'internships', 'applications', 'interviews', 'from', 'to'));
    }

    public function export(Request $request): mixed
    {
        $type   = $request->type;
        $format = $request->format;
        $from   = $request->from_date ?? now()->subMonths(6)->toDateString();
        $to     = $request->to_date   ?? now()->toDateString();

        if ($format === 'excel') {
            return match ($type) {
                'students'     => (new \App\Exports\StudentsExport($from, $to))->download(),
                'companies'    => (new \App\Exports\CompaniesExport())->download(),
                'internships'  => (new \App\Exports\InternshipsExport())->download(),
                'applications' => (new \App\Exports\ApplicationsExport($from, $to))->download(),
                'interviews'   => (new \App\Exports\InterviewsExport())->download(),
                default        => back()->with('error', 'Invalid report type.'),
            };
        }

        if ($format === 'pdf') {
            $data = match ($type) {
                'students'     => [
                    'rows'  => User::where('account_type', 'student')
                        ->whereBetween('created_at', [$from, $to])->latest()->get(),
                    'title' => 'Student Registrations',
                ],
                'companies'    => [
                    'rows'  => CompanyProfile::with('user')->latest()->get(),
                    'title' => 'Company Registrations',
                ],
                'internships'  => [
                    'rows'  => Internship::with(['company', 'category'])->latest()->get(),
                    'title' => 'Internship Listings',
                ],
                'applications' => [
                    'rows'  => Application::with(['internship', 'student.user'])
                        ->whereBetween('created_at', [$from, $to])->latest()->get(),
                    'title' => 'Applications Report',
                ],
                'interviews'   => [
                    'rows'  => Interview::with(['application.internship', 'application.student.user'])
                        ->whereBetween('created_at', [$from, $to])->latest()->get(),
                    'title' => 'Interviews Report',
                ],
                default => null,
            };

            if (! $data) {
                return back()->with('error', 'Invalid report type.');
            }

            $pdf = Pdf::loadView("reports.pdf.{$type}", array_merge($data, ['from' => $from, 'to' => $to]));
            return $pdf->download("{$type}-report.pdf");
        }

        return back()->with('error', 'Invalid export format.');
    }
}
