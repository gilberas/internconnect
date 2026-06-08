<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\CompanyProfile;
use App\Models\Internship;
use App\Models\Interview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $from = $request->from ? now()->parse($request->from)->startOfDay() : now()->subDays(30);
        $to   = $request->to   ? now()->parse($request->to)->endOfDay()   : now()->endOfDay();

        $stats = [
            'students'     => User::where('account_type', 'student')
                ->whereBetween('created_at', [$from, $to])->count(),
            'companies'    => CompanyProfile::whereBetween('created_at', [$from, $to])->count(),
            'internships'  => Internship::whereBetween('created_at', [$from, $to])->count(),
            'applications' => Application::whereBetween('created_at', [$from, $to])->count(),
            'interviews'   => Interview::whereBetween('created_at', [$from, $to])->count(),
            'accepted'     => Application::where('status', 'accepted')
                ->whereBetween('created_at', [$from, $to])->count(),
        ];

        // Applications by status
        $appsByStatus = Application::whereBetween('created_at', [$from, $to])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        // Internships by category
        $internshipsByCategory = Internship::with('category')
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw('category_id, COUNT(*) as count')
            ->groupBy('category_id')
            ->with('category:id,name')
            ->get()
            ->mapWithKeys(fn ($r) => [$r->category?->name ?? 'Uncategorized' => $r->count]);

        return view('admin.reports.index', compact(
            'stats', 'appsByStatus', 'internshipsByCategory', 'from', 'to'
        ));
    }
}
