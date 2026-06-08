<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Internship extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id', 'category_id', 'title', 'description', 'requirements',
        'responsibilities', 'skills_required', 'positions', 'location',
        'duration', 'internship_type', 'deadline', 'status',
        'rejection_reason', 'approved_by', 'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'skills_required' => 'array',
            'deadline'        => 'date',
            'approved_at'     => 'datetime',
            'positions'       => 'integer',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────

    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyProfile::class, 'company_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(InternshipCategory::class, 'category_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // ── Scopes ─────────────────────────────────────────────────────

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved')->where('deadline', '>=', now()->toDateString());
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // ── Helpers ────────────────────────────────────────────────────

    public function isEditable(): bool
    {
        return in_array($this->status, ['pending', 'rejected']);
    }

    public function isOpen(): bool
    {
        return $this->status === 'approved' && $this->deadline >= now()->toDateString();
    }

    public function typeLabel(): string
    {
        return match ($this->internship_type) {
            'full_time' => 'Full-time',
            'part_time' => 'Part-time',
            'remote'    => 'Remote',
            default     => ucfirst($this->internship_type),
        };
    }
}
