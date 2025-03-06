<?php

namespace App\Rules;

use Closure;
use Illuminate\Validation\Validator;
use Illuminate\Contracts\Validation\ValidationRule;

class InternValidator implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        
    }

    private function validateCpf(Validator $validator): void
    {
        $cpf = preg_replace( '/[^0-9]/is', '', $validator->getValue('cpf'));

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            $validator->errors()->add('cpf', 'Este CPF não é válido');
        }
        
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
               $validator->errors()->add('cpf', 'Este CPF não é válido');
            }
    }
    
    }

    function __invoke(Validator $validator)
    {
        $this->validateCpf($validator);
    }
}
