<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'gender' => 'bail|required|in:monsieur,madame',
            'lastname' => 'bail|required|between:3,40',
            'firstname' => 'bail|nullable|between:0,40',
            'company' => 'bail|required|min:5',
            'function' => 'bail|nullable|between:0,50',
            'siret' => 'bail|nullable|between:0,50',
            'tva' => 'bail|nullable|between:0,50',
            'mobile' => 'bail|nullable|between:0,25',
            'email' => 'bail|required|email',
            'phone' => 'bail|nullable|between:0,25',
            'adress' => 'bail|nullable|max:150',
            'adressBis' => 'bail|nullable|max:150',
            'zipcode' => 'bail|nullable|alpha_num|between:0,10',
            'city' => 'bail|nullable|between:0,50',
            'country' => 'bail|nullable|between:0,30|alpha',
            'notes' => 'nullable|max:500',
            'newContact' => 'nullable'
        ];
    }
}
