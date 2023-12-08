<?php

namespace App\Validation\Users;

class StoreUserValidation
{
    public static function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'picture' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'password' => 'required',
            'type' => 'required',
        ];
    }

    public static function messages(): array
    {
        return [
            'first_name' => [
                'required' => 'First name is required',
            ],
            'last_name' => [
                'required' => 'Last name is required',
            ],
            'picture' => [
                'required' => 'Picture is required',
            ],
            'phone' => [
                'required' => 'Phone is required',
            ],
            'password' => [
                'required' => 'Password is required',
            ],
            'type' => [
                'required' => 'Type is required',
            ],
        ];
    }
}
