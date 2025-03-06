<?php

namespace App\Http\Requests;

use App\Rules\InternValidator;
use Illuminate\Foundation\Http\FormRequest;

class InternRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    const NAME_REQUIRED = 'Informe um nome para o estagiário';
    const GENDER_REQUIRED = 'Informe um sexo para o estagiário';
    const BIRTH_REQUIRED = 'Informe uma data de nascimento para o estagiário';
    const BIRTH_NOT_DATE = 'Escreva um formato de data válido Ano-Mês-Dia';
    const PHONE_REQUIRED = 'Informe um telefone para o estagiário';
    const PHONE_TOO_SHORT = 'O telefone deve conter no minímo 8 caracteres ';
    const PHONE_TOO_LONG = 'O telefone deve conter no máximo 11 caracteres ';
    const CPF_REQUIRED = 'Informe um CPF para o estagiário';
    const CPF_INVALID_LENGTH = 'O CPF deve conter 11 caracteres';
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
            'name' => 'required',
            'gender' => 'required',
            'birth' => 'required|date_format:"Y-m-d"',
            'cpf' => 'required|min:11|max:14',
            'phone' => 'required|min:8|max:11'   
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
            'phone.required' => self::PHONE_REQUIRED,
            'cpf.min' => self::CPF_INVALID_LENGTH,
            'cpf.max' => self::CPF_INVALID_LENGTH,
            'phone.min' => self::PHONE_TOO_SHORT,
            'phone.max' => self::PHONE_TOO_LONG,
        ];
        
    }

    public function after(): array
    {
        return[
            new InternValidator
        ];

    }
}
