<?php

namespace App\Domains\Products\Controllers\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest;

class ViewProductControllerRequest extends FormRequest
{
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
        'sku' => 'nullable|numeric|digits_between:1,100',
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
        // Mensagens para o campo Name
        'name.required' => 'O nome do produto é obrigatório.',
        'name.string'   => 'O nome deve ser um texto válido.',
        'name.max'      => 'O nome não pode ter mais de 100 caracteres.',

        // Mensagens para SKU e Barcode
        'sku.digits'   => 'O SKU deve ter no máximo 100 dígitos.',
        'sku.numeric'   => 'O SKU deve ser um valor numérico.',
        'barcode.max'   => 'O código de barras não pode ter mais de 100 caracteres.',

        // Mensagens para o Preço (Validação Rigorosa)
        'price.required' => 'O preço é obrigatório.',
        'price.numeric'  => 'O preço deve ser um valor numérico.',
        'price.min'      => 'O preço não pode ser um valor negativo.',
        'price.regex'    => 'O preço deve ter no máximo duas casas decimais (ex: 10.99).',

        // Mensagem para o campo Active
        'active.boolean' => 'O campo ativo deve ser verdadeiro ou falso.',
    ];
}

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()
                ->withInput()
                ->withErrors($validator)
        );
    }

    protected function prepareForValidation()
{
    if ($this->has('price')) {
        $this->merge([
            'price' => str_replace(',', '.', $this->price),
        ]);
    }
}
}
