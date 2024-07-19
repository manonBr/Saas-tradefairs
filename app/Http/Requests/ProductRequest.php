<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'ranges_id' => 'required|exists:ranges,id',
            'code_art' => 'bail|required|between:3,40',
            'volume' => 'bail|nullable|max:100',
            'specificPrice' => 'bail|nullable|numeric',
            'nicotine' => 'bail|nullable|numeric|max:80',
            'name' => 'bail|required|between:0,250',
            'name_shorten' => 'bail|nullable|between:0,50'
        ];
    }
}
