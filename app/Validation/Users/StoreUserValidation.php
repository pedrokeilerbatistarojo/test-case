<?php

namespace App\Validation\Users;

class StoreUserValidation
{
    public static function rules(array $data, bool $isUpdate = false): array
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|is_unique[users.phone]',
            'email' => 'required',
            'password' => 'required',
            'type' => 'required',
        ];

        if ($isUpdate){
            $rules['id'] = 'required';
        }

        // Check if it's an update
        if (isset($data['id'])) {
            $rules['phone'] = 'required|is_unique[users.phone,id,' . $data['id'] . ']';
        }

        return $rules;
    }

    public static function messages(): array
    {
        return [
            'id' => [
                'required' => 'Id is required',
            ],
            'first_name' => [
                'required' => 'First name is required',
            ],
            'last_name' => [
                'required' => 'Last name is required',
            ],
            'phone' => [
                'required' => 'Phone is required',
                'is_unique' => 'Phone must be unique',
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
