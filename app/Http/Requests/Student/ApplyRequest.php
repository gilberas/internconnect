<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class ApplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isStudent()
            && auth()->user()->studentProfile?->hasCv();
    }

    public function rules(): array
    {
        return [
            'cv_path'          => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'cover_letter_path'=> ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'certificates'     => ['nullable', 'array', 'max:5'],
            'certificates.*'   => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ];
    }
}
