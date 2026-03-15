<?php

namespace App\Domains\Products\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
                'name' => 'required|string|max:100',
                'sku' => 'sometimes|nullable|string|max:100',
                'barcode' => 'nullable|string|max:100',
                'price' => [
                    'required',
                    'numeric',
                    'min:0',
                    'regex:/^\d+(\.\d{1,2})?$/',
                ],
                'active' => 'boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do produto é obrigatório.',
            'name.string'   => 'O nome deve ser um texto válido.',
            'name.max'      => 'O nome não pode ter mais de 100 caracteres.',

            'sku.max'   => 'O SKU não pode ter mais de 100 caracteres numéricos.',
            'sku.string'   => 'O SKU deve ser um texto válido.',
            'barcode.max'   => 'O código de barras não pode ter mais de 100 caracteres.',

            'price.required' => 'O preço é obrigatório.',
            'price.numeric'  => 'O preço deve ser um valor numérico.',
            'price.min'      => 'O preço deve ser um valor positivo.',
            'price.regex'    => 'O preço deve ter no máximo duas casas decimais (ex: 10.99).',

            'active.boolean' => 'O campo ativo deve ser verdadeiro ou falso.',
        ];
    }
}
