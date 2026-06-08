<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'internship_id', 'student_id', 'cv_path', 'cover_letter_path',
        'status', 'company_notes',
    ];

    // ── Relationships ──────────────────────────────────────────────

    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class, 'student_id');
    }

    public function interview(): HasOne
    {
        return $this->hasOne(Interview::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(ApplicationCertificate::class);
    }

    // ── Helpers ────────────────────────────────────────────────────

    public function statusLabel(): string
    {
        return ucwords(str_replace('_', ' ', $this->status));
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'submitted'          => 'blue',
            'under_review'       => 'indigo',
            'shortlisted'        => 'purple',
            'interview_scheduled'=> 'amber',
            'accepted'           => 'emerald',
            'rejected'           => 'red',
            default              => 'gray',
        };
    }
}
