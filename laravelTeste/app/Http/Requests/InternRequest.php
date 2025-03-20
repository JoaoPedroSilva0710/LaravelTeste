<?php

namespace App\Http\Requests;

use App\Helpers\Traits\Date;
use App\Helpers\Traits\RegexPatterns;
use App\Rules\InternValidator;
use Illuminate\Foundation\Http\FormRequest;

class InternRequest extends FormRequest
{
    use RegexPatterns;
    use Date; 

    protected $stopOnFirstFailure = true;

    const NAME_REQUIRED = 'Informe um nome para o estagiário';
    const GENDER_REQUIRED = 'Informe um sexo para o estagiário';
    const BIRTH_REQUIRED = 'Informe uma data de nascimento para o estagiário';
    const BIRTH_NOT_DATE = 'Escreva um formato de data válido Ano-Mês-Dia';
    const CPF_REQUIRED = 'Informe um CPF para o estagiário';
    const CPF_INVALID_LENGTH = 'O CPF deve conter 11 caracteres';
    const PHONE_REQUIRED = 'Informe um telefone para o estagiário';
    const PHONE_IS_INVALID = 'O número de telefone é inválido';
    const GENDER_PATTERN = 'O genêro enviado deve ser F, M ou O';
    const NAME_VALID = 'Informe um nome válido para o usuário';
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => "required|regex:$this->regex_name_pattern",
            'gender' => "required|regex:$this->regex_sex_pattern",
            'birth' => "required|date_format:$this->dateStandardFormat",
            'cpf' => "required|min:11|max:14",
            'phone' => "required|regex:$this->regex_phone"   
        ];
    }

    public function messages(): array
    {
        return[
            'name.required' => self::NAME_REQUIRED,
            'gender.required' => self::GENDER_REQUIRED,
            'birth.required' => self::BIRTH_REQUIRED,
            'birth.date_format' => self::BIRTH_NOT_DATE,
            'cpf.required' => self::CPF_REQUIRED,
            'cpf.min' => self::CPF_INVALID_LENGTH,
            'cpf.max' => self::CPF_INVALID_LENGTH,
            'phone.required' => self::PHONE_REQUIRED,
            'phone.regex' => self::PHONE_IS_INVALID,
            'gender.regex' => self::GENDER_PATTERN,
            'name.regex' => self::NAME_VALID
        ];
        
    }

    public function after(): array
    {
        return[
            new InternValidator
        ];

    }
}
