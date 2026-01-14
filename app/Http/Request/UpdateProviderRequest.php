<?php
namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProviderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }
    
    public function rules(): array
    {
        $providerId = $this->route('provider')->id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('providers')->ignore($providerId),
            ],
            'contact_person' => 'nullable|string|max:255',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('providers')->ignore($providerId),
            ],
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'rfc' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('providers')->ignore($providerId),
            ],
            'status' => 'required|in:active,inactive,pending',
            'notes' => 'nullable|string|max:1000',
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del proveedor es obligatorio.',
            'name.unique' => 'El nombre del proveedor ya está en uso.',
            'name.max' => 'El nombre no puede exceder los 255 caracteres.',
            
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.unique' => 'El correo electrónico ya está registrado con otro proveedor.',
            'email.max' => 'El correo electrónico no puede exceder los 255 caracteres.',
            
            'phone.max' => 'El teléfono no puede exceder los 50 caracteres.',
            
            'address.max' => 'La dirección no puede exceder los 500 caracteres.',
            
            'rfc.unique' => 'El RFC ya está registrado con otro proveedor.',
            'rfc.max' => 'El RFC no puede exceder los 20 caracteres.',
            
            'status.required' => 'El estado del proveedor es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido.',
            
            'notes.max' => 'Las notas no pueden exceder los 1000 caracteres.',
        ];
    }
    
    public function attributes(): array
    {
        return [
            'name' => 'nombre del proveedor',
            'contact_person' => 'persona de contacto',
            'email' => 'correo electrónico',
            'phone' => 'teléfono',
            'address' => 'dirección',
            'rfc' => 'RFC',
            'status' => 'estado',
            'notes' => 'notas',
        ];
    }
}