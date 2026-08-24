<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'surname' => [
                'required',
                'string',
                'max:255'
            ],
            'patronymic' => [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'confirmed',
                Password::default(),
            ],
            'group_id' => [
                'required',
                'exists:groups,id'
            ],
        ];
    }
}
