<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class Restricted implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */

public function __construct(protected array $word =[])
    {
        //
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach($this->word as $word){
            if(str_contains($value,$word)){
                $fail('The '.$attribute.' should not contain the word '.$word.'.');
            }
        } 
    }
}
