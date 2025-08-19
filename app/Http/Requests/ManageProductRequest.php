<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManageProductRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'stock_quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:1',
            'id_products_categories' => 'nullable|integer|min:0',
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
