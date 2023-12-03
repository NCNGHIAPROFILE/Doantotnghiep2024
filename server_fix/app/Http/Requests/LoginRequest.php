<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'This is not email',
            'email.unique' => 'Email already exists',
            'password.required' => 'Password is required',
            'password.min' => 'Password is too short' 
        ];
    }
}
