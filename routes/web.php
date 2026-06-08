<?php

use Illuminate\Support\Facades\Route;

// ── Public ────────────────────────────────────────────────────────────────────
Route::get('/', fn () => view('welcome'))->name('home');

// ── Role-aware dashboard redirect ─────────────────────────────────────────────
Route::get('/dashboard', function () {
    return redirect()->route(auth()->user()->dashboardRoute());
})->middleware(['auth', 'verified'])->name('dashboard');

// ── Student ───────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'role:student'])
    ->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', fn () => view('student.dashboard'))->name('dashboard');

        Route::get('/profile/setup',  [\App\Http\Controllers\Student\ProfileController::class, 'setup'])->name('profile.setup');
        Route::get('/profile',        [\App\Http\Controllers\Student\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile',        [\App\Http\Controllers\Student\ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/cv',    [\App\Http\Controllers\Student\ProfileController::class, 'uploadCv'])->name('profile.cv');
        Route::post('/profile/photo', [\App\Http\Controllers\Student\ProfileController::class, 'uploadPhoto'])->name('profile.photo');

        Route::get('/internships',              [\App\Http\Controllers\Student\InternshipController::class, 'index'])->name('internships.index');
        Route::get('/internships/{internship}', [\App\Http\Controllers\Student\InternshipController::class, 'show'])->name('internships.show');

        Route::post('/internships/{internship}/save', [\App\Http\Controllers\Student\SavedInternshipController::class, 'toggle'])->name('internships.save');
        Route::get('/saved',                          [\App\Http\Controllers\Student\SavedInternshipController::class, 'index'])->name('saved.index');

        Route::post('/internships/{internship}/apply', [\App\Http\Controllers\Student\ApplicationController::class, 'store'])->name('applications.store');
        Route::get('/applications',                    [\App\Http\Controllers\Student\ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}',      [\App\Http\Controllers\Student\ApplicationController::class, 'show'])->name('applications.show');
    });

// ── Company ───────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'role:company'])
    ->prefix('company')->name('company.')->group(function () {
        Route::get('/dashboard', fn () => view('company.dashboard'))->name('dashboard');

        Route::get('/setup',  [\App\Http\Controllers\Company\ProfileController::class, 'setup'])->name('setup');
        Route::post('/setup', [\App\Http\Controllers\Company\ProfileController::class, 'storeSetup'])->name('setup.store');
        Route::get('/profile',  [\App\Http\Controllers\Company\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile',  [\App\Http\Controllers\Company\ProfileController::class, 'update'])->name('profile.update');

        Route::resource('internships', \App\Http\Controllers\Company\InternshipController::class);
        Route::patch('/internships/{internship}/close', [\App\Http\Controllers\Company\InternshipController::class, 'close'])->name('internships.close');

        Route::get('/internships/{internship}/applicants',               [\App\Http\Controllers\Company\ApplicantController::class, 'index'])->name('applicants.index');
        Route::get('/internships/{internship}/applicants/{application}', [\App\Http\Controllers\Company\ApplicantController::class, 'show'])->name('applicants.show');
        Route::patch('/applications/{application}/status',               [\App\Http\Controllers\Company\ApplicantController::class, 'updateStatus'])->name('applications.status');

        Route::post('/applications/{application}/interview', [\App\Http\Controllers\Company\InterviewController::class, 'store'])->name('interviews.store');
        Route::put('/interviews/{interview}',                [\App\Http\Controllers\Company\InterviewController::class, 'update'])->name('interviews.update');
        Route::patch('/interviews/{interview}/cancel',       [\App\Http\Controllers\Company\InterviewController::class, 'cancel'])->name('interviews.cancel');
    });

// ── Admin ─────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/companies',                    [\App\Http\Controllers\Admin\CompanyController::class, 'index'])->name('companies.index');
        Route::get('/companies/{company}',          [\App\Http\Controllers\Admin\CompanyController::class, 'show'])->name('companies.show');
        Route::patch('/companies/{company}/verify', [\App\Http\Controllers\Admin\CompanyController::class, 'verify'])->name('companies.verify');
        Route::patch('/companies/{company}/reject', [\App\Http\Controllers\Admin\CompanyController::class, 'reject'])->name('companies.reject');
        Route::patch('/companies/{company}/revoke', [\App\Http\Controllers\Admin\CompanyController::class, 'revoke'])->name('companies.revoke');

        Route::get('/internships',                        [\App\Http\Controllers\Admin\InternshipController::class, 'index'])->name('internships.index');
        Route::get('/internships/{internship}',           [\App\Http\Controllers\Admin\InternshipController::class, 'show'])->name('internships.show');
        Route::patch('/internships/{internship}/approve', [\App\Http\Controllers\Admin\InternshipController::class, 'approve'])->name('internships.approve');
        Route::patch('/internships/{internship}/reject',  [\App\Http\Controllers\Admin\InternshipController::class, 'reject'])->name('internships.reject');

        Route::get('/users',                      [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}',               [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
        Route::patch('/users/{user}/suspend',     [\App\Http\Controllers\Admin\UserController::class, 'suspend'])->name('users.suspend');
        Route::patch('/users/{user}/reactivate',  [\App\Http\Controllers\Admin\UserController::class, 'reactivate'])->name('users.reactivate');

        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::patch('/categories/{category}/toggle', [\App\Http\Controllers\Admin\CategoryController::class, 'toggle'])->name('categories.toggle');

        Route::get('/reports',        [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');

        Route::get('/activity', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity.index');
    });

// ── Shared profile ────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
