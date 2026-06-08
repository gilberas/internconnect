<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\CompanyProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(Request $request): View
    {
        $query = CompanyProfile::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('verification_status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('company_name', 'like', '%' . $request->search . '%');
        }

        $companies = $query->paginate(15)->withQueryString();

        $counts = [
            'total'    => CompanyProfile::count(),
            'pending'  => CompanyProfile::where('verification_status', 'pending')->count(),
            'verified' => CompanyProfile::where('verification_status', 'verified')->count(),
            'rejected' => CompanyProfile::where('verification_status', 'rejected')->count(),
        ];

        return view('admin.companies.index', compact('companies', 'counts'));
    }

    public function show(CompanyProfile $company): View
    {
        $company->load(['user', 'documents', 'internships']);
        return view('admin.companies.show', compact('company'));
    }

    public function verify(CompanyProfile $company): RedirectResponse
    {
        $company->update([
            'verification_status' => 'verified',
            'rejection_reason'    => null,
            'verified_at'         => now(),
            'verified_by'         => auth()->id(),
        ]);

        ActivityLog::record('verify_company', auth()->user(), $company);

        return back()->with('status', "Company '{$company->company_name}' verified successfully.");
    }

    public function reject(CompanyProfile $company, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'rejection_reason' => ['required', 'string', 'min:10', 'max:500'],
        ]);

        $company->update([
            'verification_status' => 'rejected',
            'rejection_reason'    => $data['rejection_reason'],
        ]);

        ActivityLog::record('reject_company', auth()->user(), $company);

        return back()->with('status', "Company rejected. Reason sent to company.");
    }

    public function revoke(CompanyProfile $company): RedirectResponse
    {
        $company->update(['verification_status' => 'pending']);
        // Close all active internships
        $company->internships()->where('status', 'approved')->update(['status' => 'closed']);

        ActivityLog::record('revoke_company_verification', auth()->user(), $company);

        return back()->with('status', 'Verification revoked. Active internships closed.');
    }
}
