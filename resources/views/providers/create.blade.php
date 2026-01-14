@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Encabezado -->
        <div class="mb-8 text-center">
            <div class="inline-block p-4 bg-blue-50 rounded-full mb-4">
                <i class="fas fa-user-tie text-blue-600 text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Registrar Nuevo Proveedor</h1>
            <p class="text-gray-600">Complete la información del proveedor para comenzar a registrar ingresos y gastos asociados.</p>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('providers.store') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <!-- Información básica -->
                    <div class="border-b border-gray-200 pb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-id-card text-blue-600 mr-2"></i> Información Básica
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nombre del Proveedor <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       placeholder="Ej: Proveedor de Materiales S.A."
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- RFC -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    RFC
                                    <span class="text-xs text-gray-500 font-normal">(Opcional)</span>
                                </label>
                                <input type="text" name="rfc" value="{{ old('rfc') }}"
                                       placeholder="Ej: XAXX010101000"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4 uppercase">
                                @error('rfc')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Información de contacto -->
                    <div class="border-b border-gray-200 pb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-address-book text-blue-600 mr-2"></i> Información de Contacto
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Persona de contacto -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Persona de Contacto
                                </label>
                                <input type="text" name="contact_person" value="{{ old('contact_person') }}"
                                       placeholder="Ej: Juan Pérez"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4">
                                @error('contact_person')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Teléfono
                                </label>
                                <input type="tel" name="phone" value="{{ old('phone') }}"
                                       placeholder="Ej: 555-123-4567"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4">
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Correo Electrónico
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                       placeholder="Ej: contacto@proveedor.com"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Dirección -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Dirección
                                </label>
                                <textarea name="address" rows="3"
                                          placeholder="Ej: Av. Principal #123, Col. Centro, Ciudad, Estado"
                                          class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Estado y notas -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-cog text-blue-600 mr-2"></i> Configuración
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Estado -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Estado <span class="text-red-500">*</span>
                                </label>
                                <select name="status" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4">
                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                        Activo
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactivo
                                    </option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                                        Pendiente
                                    </option>
                                </select>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notas -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Notas Adicionales
                                </label>
                                <textarea name="notes" rows="4"
                                          placeholder="Información adicional sobre el proveedor..."
                                          class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="mt-10 pt-6 border-t border-gray-200 flex justify-end space-x-4">
                    <a href="{{ route('providers.index') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 flex items-center">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center shadow">
                        <i class="fas fa-save mr-2"></i> Registrar Proveedor
                    </button>
                </div>
            </form>
        </div>

        <!-- Información de ayuda -->
        <div class="mt-8 bg-green-50 border border-green-200 rounded-xl p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-question-circle text-green-500 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-green-800 mb-2">¿Por qué registrar proveedores?</h3>
                    <ul class="space-y-2 text-green-700">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                            <span>Permite asociar ingresos y gastos a un proveedor específico</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                            <span>Facilita el cálculo de utilidades por proveedor</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                            <span>Mejora la organización y trazabilidad de las transacciones</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                            <span>Permite generar reportes detallados por proveedor</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-format RFC
        const rfcInput = document.querySelector('input[name="rfc"]');
        rfcInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    });
</script>
@endsection