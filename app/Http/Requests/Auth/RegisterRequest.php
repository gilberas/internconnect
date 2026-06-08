<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'account_type' => ['required', 'in:student,company'],
            'password'     => ['required', 'confirmed',
                               Password::min(8)->mixedCase()->numbers()->symbols()],
        ];
    }
}
