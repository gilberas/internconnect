<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interview extends Model
{
    protected $fillable = [
        'application_id', 'interview_date', 'interview_time', 'interview_type',
        'venue', 'meeting_link', 'instructions', 'status', 'reschedule_history',
    ];

    protected function casts(): array
    {
        return [
            'interview_date'     => 'date',
            'reschedule_history' => 'array',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function typeLabel(): string
    {
        return match ($this->interview_type) {
            'physical' => 'Physical (In-person)',
            'online'   => 'Online',
            'phone'    => 'Phone Call',
            default    => ucfirst($this->interview_type),
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'scheduled'   => 'blue',
            'confirmed'   => 'emerald',
            'rescheduled' => 'amber',
            'completed'   => 'gray',
            'cancelled'   => 'red',
            default       => 'gray',
        };
    }
}
