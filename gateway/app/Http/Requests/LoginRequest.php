<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'Поле email обязательно для заполнения.',
            'email.email'       => 'Введите действительный email.',
            'password.required' => 'Поле пароля обязательно для заполнения.',
        ];
    }
}
