<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\CompanyProfile;
use App\Models\Internship;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'pending_companies'   => CompanyProfile::where('verification_status', 'pending')->count(),
            'pending_internships' => Internship::where('status', 'pending')->count(),
            'total_students'      => User::where('account_type', 'student')->count(),
            'total_companies'     => CompanyProfile::where('verification_status', 'verified')->count(),
            'total_applications'  => Application::count(),
            'total_internships'   => Internship::where('status', 'approved')->count(),
        ];

        $recentCompanies   = CompanyProfile::where('verification_status', 'pending')
            ->with('user')->latest()->take(5)->get();
        $recentInternships = Internship::where('status', 'pending')
            ->with('company')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentCompanies', 'recentInternships'));
    }
}
