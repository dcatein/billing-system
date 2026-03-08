<?php

namespace App\Domains\Products\Controllers\Requests;

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
            'name' => 'required|string',
            'sku' => 'nullable|string',
            'barcode' => 'nullable|string',
            'price' => 'required|numeric',
            'active' => 'boolean'
        ];
    }
}
