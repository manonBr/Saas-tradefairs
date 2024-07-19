<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AtLeastOnce implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $filtered = array_filter($value, function($data) { return !is_null($data); }) ;
        if( ! $filtered ) {
            $fail('La commande ne peut pas être vide !');
        }

    }
}
