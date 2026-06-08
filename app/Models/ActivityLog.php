<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    public $timestamps = false;

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id', 'action', 'subject_type', 'subject_id',
        'ip_address', 'user_agent', 'extra', 'created_at',
    ];

    protected function casts(): array
    {
        return ['extra' => 'array', 'created_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Convenience static method to log an action.
     */
    public static function record(
        string $action,
        ?User $user = null,
        ?Model $subject = null,
        array $extra = []
    ): void {
        static::create([
            'user_id'      => $user?->id,
            'action'       => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id'   => $subject?->id,
            'ip_address'   => request()->ip(),
            'user_agent'   => request()->userAgent(),
            'extra'        => $extra ?: null,
            'created_at'   => now(),
        ]);
    }
}
