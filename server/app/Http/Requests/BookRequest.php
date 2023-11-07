<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'NameBook' => 'required|String',
            'Author' => 'required|String',
            'MaAdmin' => 'required|String',
            'Category' => 'required|String',
            'Type' => 'required|between:0,1',
            'MaProducer' => 'required|string',
            'YearPublish' => 'required|date',
            'Quantity' => 'required|string|min:0',
            'Content' => 'string',
            'Status' => 'required|between:0,1',
            'Sum_Quantity' => 'required|string|min:1',
        ];
    }
}
