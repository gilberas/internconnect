<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'account_type', 'status', 'suspended_reason', 'suspended_at', 'suspended_by'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isStudent(): bool  { return $this->account_type === 'student'; }
    public function isCompany(): bool  { return $this->account_type === 'company'; }
    public function isAdmin(): bool    { return $this->account_type === 'admin'; }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function companyProfile()
    {
        return $this->hasOne(CompanyProfile::class);
    }

    public function dashboardRoute(): string
    {
        return match ($this->account_type) {
            'company' => 'company.dashboard',
            'admin'   => 'admin.dashboard',
            default   => 'student.dashboard',
        };
    }
}
