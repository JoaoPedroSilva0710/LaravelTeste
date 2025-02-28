<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InternRequest extends FormRequest
{
    const NAME_REQUIRED = 'Informe um nome para o estagiário';
    const GENDER_REQUIRED = 'Informe um sexo para o estagiário';
    const BIRTH_REQUIRED = 'Informe uma data de nascimento para o estagiário';
    const PHONE_REQUIRED = 'Informe um telefone para o estagiário';
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
            "name" => "required",
            "gender" => "required",
            "birth" => "required",
            "cpf" => "required",
            "phone" => "required"   
        ];
    }

    public function messages(): array
    {
        return[
            'name.required' => 'Informe o nome do estagiário',
            'gender.required' => 'Informe o sexo do estagiário',
            'birth.required' => 'Informe a data de nascimento do estagiário',
            'phone.required' => 'Informe o telefone do estagiário',
            'cpf.required' => 'Informe o cpf do estagiário',
        ];
        
    }
}
