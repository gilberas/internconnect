<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use App\Notifications\AccountSuspendedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('account_type', '!=', 'admin')->latest();

        if ($request->filled('type')) {
            $query->where('account_type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(fn ($q) =>
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
            );
        }

        $users = $query->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $user->load(['studentProfile', 'companyProfile.internships']);
        return view('admin.users.show', compact('user'));
    }

    public function suspend(User $user, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'suspended_reason' => ['required', 'string', 'min:10', 'max:500'],
        ]);

        $user->update([
            'status'           => 'suspended',
            'suspended_reason' => $data['suspended_reason'],
            'suspended_at'     => now(),
            'suspended_by'     => auth()->id(),
        ]);

        // Close company internships if suspending a company
        if ($user->isCompany()) {
            $user->companyProfile?->internships()
                ->where('status', 'approved')
                ->update(['status' => 'closed']);
        }

        ActivityLog::record('suspend_user', auth()->user(), $user);
        $user->notify(new AccountSuspendedNotification($user));

        return back()->with('status', "User '{$user->name}' suspended.");
    }

    public function reactivate(User $user): RedirectResponse
    {
        $user->update([
            'status'           => 'active',
            'suspended_reason' => null,
            'suspended_at'     => null,
            'suspended_by'     => null,
        ]);

        ActivityLog::record('reactivate_user', auth()->user(), $user);

        return back()->with('status', "User '{$user->name}' reactivated.");
    }
}
