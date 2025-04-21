<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'price'         => 'required|numeric|min:0',
            'image'         => 'required|url',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required'        => 'The product title is required.',
            'title.max'             => 'The product title cannot exceed 255 characters.',
            'description.required'  => 'The product description is required.',
            'price.required'        => 'The product price is required.',
            'price.numeric'         => 'The price must be a number.',
            'price.min'             => 'The price cannot be negative.',
            'image.required'        => 'The product image URL is required.',
            'image.url'             => 'The image must be a valid URL.',
        ];
    }
}
