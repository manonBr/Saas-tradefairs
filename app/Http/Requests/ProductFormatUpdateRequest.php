<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductFormatUpdateRequest extends FormRequest
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
            'active' => '',
            'productType_id' => [
                'required',
                Rule::unique('product_type_volumes_nicotines', 'productType_id')
                    ->where('volumes_id', $this->input('volumes_id'))
                    ->where('nicotines_id', $this->input('nicotines_id'))
                    ->where('id', '!=', $this->input('id')),
            ],
            'volumes_id' => [
                'required',
                Rule::unique('product_type_volumes_nicotines', 'volumes_id')
                    ->where('productType_id', $this->input('productType_id'))
                    ->where('nicotines_id', $this->input('nicotines_id'))
                    ->where('id', '!=',$this->input('id')),
            ],
            'nicotines_id' => [
                'required',
                Rule::unique('product_type_volumes_nicotines', 'nicotines_id')
                    ->where('volumes_id', $this->input('volumes_id'))
                    ->where('productType_id', $this->input('productType_id'))
                    ->where('id', '!=',$this->input('id')),
            ]
        ];
    }
}
