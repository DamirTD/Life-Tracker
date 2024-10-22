<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest as FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'services' => 'required|array',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Поле имени обязательно для заполнения.',
            'email.required'     => 'Поле email обязательно для заполнения.',
            'email.unique'       => 'Этот email уже зарегистрирован.',
            'password.required'  => 'Поле пароля обязательно для заполнения.',
            'password.confirmed' => 'Пароли не совпадают.',
            'services.required'  => 'Необходимо выбрать хотя бы один сервис.',
        ];
    }
}
