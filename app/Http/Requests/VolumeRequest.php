<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VolumeRequest extends FormRequest
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
            'volume' => 'bail|required|between:1,30',
            'label' => 'required'
        ];
    }
}
