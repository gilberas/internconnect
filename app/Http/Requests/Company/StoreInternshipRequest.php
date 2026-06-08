<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreInternshipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isCompany()
            && auth()->user()->companyProfile?->isVerified();
    }

    public function rules(): array
    {
        return [
            'title'            => ['required', 'string', 'max:255'],
            'category_id'      => ['required', 'exists:internship_categories,id'],
            'description'      => ['required', 'string', 'min:50'],
            'requirements'     => ['required', 'string'],
            'responsibilities' => ['required', 'string'],
            'skills_required'  => ['nullable', 'array'],
            'skills_required.*'=> ['string', 'max:100'],
            'positions'        => ['required', 'integer', 'min:1', 'max:100'],
            'location'         => ['required', 'string', 'max:255'],
            'duration'         => ['required', 'string', 'max:100'],
            'internship_type'  => ['required', 'in:full_time,part_time,remote'],
            'deadline'         => ['required', 'date', 'after:today'],
        ];
    }
}
