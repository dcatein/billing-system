<?php

namespace App\Domains\Orders\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreOrderRequest extends FormRequest
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
            'discount_value' => 'nullable|numeric',
            'discount_type' => 'nullable',
            'notes' => 'nullable|string',
            'customer_id' => 'nullable|integer',
            'user_id' => 'required|integer',
            'items' => 'required|array',
            'payments' => 'nullable|array', //Rule::contains(['admin', 'editor']),
            'pickup' => 'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        //
    }
}
