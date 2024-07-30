<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidatePhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $pattern;
    protected $message;
    public function __construct($pattern = '/^\d{10}$/', $message = null)
    {
        $this->pattern = $pattern;
        $this->message = $message;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match($this->pattern, $value)) {
            $fail($this->message ?: ':attribute is not a valid number');
        }
    }
}
