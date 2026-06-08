<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'account_type',
        'status',
        'suspended_reason',
        'suspended_at',
        'suspended_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'suspended_at'      => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────

    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function companyProfile(): HasOne
    {
        return $this->hasOne(CompanyProfile::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    // ── Helpers ────────────────────────────────────────────────────

    public function isStudent(): bool { return $this->account_type === 'student'; }
    public function isCompany(): bool { return $this->account_type === 'company'; }
    public function isAdmin(): bool   { return $this->account_type === 'admin'; }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    public function dashboardRoute(): string
    {
        return match ($this->account_type) {
            'student' => 'student.dashboard',
            'company' => 'company.dashboard',
            'admin'   => 'admin.dashboard',
            default   => 'dashboard',
        };
    }
}
