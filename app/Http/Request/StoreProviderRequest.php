<?php
namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreProviderRequest extends FormRequest
{
   
    public function authorize(): bool
    {
      
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:providers,name',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:providers,email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'rfc' => [
                'nullable',
                'string',
                'max:20',
                'unique:providers,rfc',
                'regex:/^[A-Z&Ñ]{3,4}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z0-9]{2}[0-9A]$/',
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
            'email.unique' => 'El correo electrónico ya está registrado.',
            'email.max' => 'El correo electrónico no puede exceder los 255 caracteres.',
            
            'phone.max' => 'El teléfono no puede exceder los 50 caracteres.',
            
            'address.max' => 'La dirección no puede exceder los 500 caracteres.',
            
            'rfc.regex' => 'El formato del RFC no es válido. Ejemplo: XAXX010101000',
            'rfc.unique' => 'El RFC ya está registrado.',
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

    protected function prepareForValidation(): void
    {
        if ($this->has('rfc')) {
            $this->merge([
                'rfc' => strtoupper($this->rfc),
            ]);
        }

        // Limpiar espacios en blanco
        $this->merge([
            'name' => trim($this->name),
            'contact_person' => $this->contact_person ? trim($this->contact_person) : null,
            'email' => $this->email ? trim($this->email) : null,
            'phone' => $this->phone ? trim($this->phone) : null,
            'address' => $this->address ? trim($this->address) : null,
            'notes' => $this->notes ? trim($this->notes) : null,
        ]);
    }
}