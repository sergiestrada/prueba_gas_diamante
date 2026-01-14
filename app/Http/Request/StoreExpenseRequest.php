<?php

namespace App\Http\Request;


use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
      public function authorize():bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'provider_id' => 'required|exists:providers,id',
            'amount' => 'required|numeric|min:0.01',
            'concept' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'provider_id.required' => 'El proveedor es obligatorio.',
            'amount.required' => 'El monto es obligatorio.',
            'amount.min' => 'El monto debe ser mayor a 0.',
            'concept.required' => 'El concepto es obligatorio.',
            'date.required' => 'La fecha es obligatoria.',
        ];
    }
}
