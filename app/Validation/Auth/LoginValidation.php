<?php

namespace App\Validation\Auth;

class LoginValidation
{
    public static function rules(): array
    {
        return [
            'phone'    => 'required',
            'password' => 'required',
        ];
    }

    public static function messages(): array
    {
        return [
            'phone' => [
                'required' => 'Phone is required',
            ],
            'password' => [
                'required' => 'Password is required',
            ],
        ];
    }
}
