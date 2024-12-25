<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class GenerateProductEstimateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'products' => ['required', 'array'],
            'products.*.id' => ['integer', 'exists:products,id'],
            'products.*.quantity' => ['integer', 'min:1', 'max:25'],
            'installation_cost' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
