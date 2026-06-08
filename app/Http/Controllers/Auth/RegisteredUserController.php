<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Models\StudentProfile;
use App\Models\User;
use App\Rules\StrongPassword;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password'     => ['required', 'confirmed', new StrongPassword],
            'account_type' => ['required', 'in:student,company'],
        ]);

        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'account_type' => $request->account_type,
            'status'       => 'active',
        ]);

        $user->assignRole($request->account_type);

        if ($request->account_type === 'student') {
            StudentProfile::create([
                'user_id'         => $user->id,
                'full_name'       => $request->name,
                'university'      => '',
                'program'         => '',
                'graduation_year' => now()->year,
            ]);
        } else {
            CompanyProfile::create([
                'user_id'             => $user->id,
                'company_name'        => '',
                'registration_number' => '',
                'contact_person'      => $request->name,
                'address'             => '',
                'phone'               => '',
            ]);

            User::where('account_type', 'admin')->each(
                fn ($admin) => $admin->notify(
                    new \App\Notifications\CompanySubmittedNotification($user->companyProfile)
                )
            );
        }

        event(new Registered($user));
        Auth::login($user);

        session()->flash('status', 'Account created successfully! Please verify your email.');

        return redirect()->route('verification.notice');
    }
}
