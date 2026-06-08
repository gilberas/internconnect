<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyProfile extends Model
{
    protected $fillable = [
        'user_id', 'company_name', 'registration_number', 'contact_person',
        'address', 'phone', 'website', 'logo_path', 'social_links',
        'verification_status', 'rejection_reason', 'verified_at', 'verified_by',
    ];

    protected function casts(): array
    {
        return [
            'social_links' => 'array',
            'verified_at'  => 'datetime',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(CompanyDocument::class, 'company_id');
    }

    public function internships(): HasMany
    {
        return $this->hasMany(Internship::class, 'company_id');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // ── Helpers ────────────────────────────────────────────────────

    public function isPending(): bool   { return $this->verification_status === 'pending'; }
    public function isVerified(): bool  { return $this->verification_status === 'verified'; }
    public function isRejected(): bool  { return $this->verification_status === 'rejected'; }
}
