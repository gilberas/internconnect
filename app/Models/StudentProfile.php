<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentProfile extends Model
{
    protected $fillable = [
        'user_id', 'full_name', 'gender', 'date_of_birth', 'phone',
        'university', 'program', 'graduation_year',
        'skills', 'cv_path', 'cover_letter_path', 'profile_photo_path',
        'completion_percentage',
    ];

    protected function casts(): array
    {
        return [
            'skills'          => 'array',
            'date_of_birth'   => 'date',
            'graduation_year' => 'integer',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'student_id');
    }

    public function savedInternships(): HasMany
    {
        return $this->hasMany(SavedInternship::class, 'student_id');
    }

    // ── Scopes & Helpers ───────────────────────────────────────────

    public function hasCv(): bool
    {
        return ! empty($this->cv_path);
    }

    public function calculateCompletionPercentage(): int
    {
        $fields  = ['full_name', 'phone', 'university', 'program', 'graduation_year',
                     'skills', 'cv_path', 'profile_photo_path'];
        $filled  = array_filter($fields, fn ($f) => ! empty($this->{$f}));
        $pct     = (int) round(count($filled) / count($fields) * 100);
        $this->update(['completion_percentage' => $pct]);
        return $pct;
    }
}
