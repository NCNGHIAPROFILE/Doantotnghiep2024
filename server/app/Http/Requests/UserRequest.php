<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'MaSV' => 'required|string|min:8',
            'LastNameUser'=> 'required|string',
            'FistNameUser'=> 'required|string',
            'Class'=> 'required|string|min:4',
            'Phone'=> 'min:10|string',
            'email'=> 'required|string|email|max:30',
            'password'=> 'required|string|min:8',
            'ImageUser' => 'mimes:jpeg,png,jpg'
        ];
    }
}
