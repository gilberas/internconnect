<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyDocument extends Model
{
    protected $fillable = [
        'company_id', 'document_type', 'original_filename',
        'file_path', 'mime_type', 'file_size', 'uploaded_at',
    ];

    protected function casts(): array
    {
        return ['uploaded_at' => 'datetime'];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyProfile::class, 'company_id');
    }

    public function labelForType(): string
    {
        return match ($this->document_type) {
            'brela' => 'BRELA Certificate',
            'nida'  => 'NIDA Identification',
            'tra'   => 'TRA Certificate',
            default => 'Supporting Document',
        };
    }
}
