<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductTypeUpdateRequest extends FormRequest
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
            'id' => 'required',
            'order' => 'bail|required|numeric|between:0,10',
            'type' => 'bail|required|between:1,30|alpha',
            'label' => 'required'
        ];
    }
}
