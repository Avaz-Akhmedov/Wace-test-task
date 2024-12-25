<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class SearchProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'query' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'query.required' => 'Please add parameter query to search like that ?query'
        ];
    }
}
