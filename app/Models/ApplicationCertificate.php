<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationCertificate extends Model
{
    protected $fillable = ['application_id', 'original_filename', 'file_path', 'mime_type'];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
