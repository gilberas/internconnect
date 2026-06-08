<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StrongPassword implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $message = 'Password must be at least 8 characters and include uppercase, lowercase, number, and special character.';

        if (
            strlen($value) < 8 ||
            ! preg_match('/[A-Z]/', $value) ||
            ! preg_match('/[a-z]/', $value) ||
            ! preg_match('/[0-9]/', $value) ||
            ! preg_match('/[@$!%*?&#]/', $value)
        ) {
            $fail($message);
        }
    }
}
