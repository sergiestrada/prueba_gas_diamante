<?php 
namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
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
}

 ?>