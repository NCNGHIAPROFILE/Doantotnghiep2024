<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'NameAdmin' => 'required|String',
            'AddressAdmin' => 'required|String',
            //'AddressAdmin' => 'file|mimes:png,jpg,pdf|max:102400',
            'Phone' => 'required|min:10',
            'email' => 'required|string|email|max:30',
        ];
    }
}
