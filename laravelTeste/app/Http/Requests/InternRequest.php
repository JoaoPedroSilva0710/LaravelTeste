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

    const REQUIRED_NAME = 'Informe um nome para o estagiário';
    const REQUIRED_GENDER = 'Informe um sexo para o estagiário';
    const REQUIRED_BIRTH = 'Informe uma data de nascimento para o estagiário';
    const INVALID_BIRTH_DATE_FORMAT = 'Escreva um formato de data válido Ano-Mês-Dia';
    const REQUIRED_CPF = 'Informe um CPF para o estagiário';
    const INVALID_CPF_LENGTH = 'O CPF deve conter 11 caracteres';
    const REQUIRED_PHONE = 'Informe um telefone para o estagiário';
    const INVALID_PHONE_NUMBER = 'O número de telefone é inválido';
    const GENDER_VALIDATION_PATTERN = 'O genêro enviado deve ser F, M ou O';
    const INVALID_NAME = 'Informe um nome válido para o usuário';
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
            'name.required' => self::REQUIRED_NAME,
            'gender.required' => self::REQUIRED_GENDER,
            'birth.required' => self::REQUIRED_BIRTH,
            'birth.date_format' => self::INVALID_BIRTH_DATE_FORMAT,
            'cpf.required' => self::REQUIRED_CPF,
            'cpf.min' => self::INVALID_CPF_LENGTH,
            'cpf.max' => self::INVALID_CPF_LENGTH,
            'phone.required' => self::REQUIRED_PHONE,
            'phone.regex' => self::INVALID_PHONE_NUMBER,
            'gender.regex' => self::GENDER_VALIDATION_PATTERN,
            'name.regex' => self::INVALID_NAME
        ];
        
    }

    public function after(): array
    {
        return[
            new InternValidator
        ];

    }
}
