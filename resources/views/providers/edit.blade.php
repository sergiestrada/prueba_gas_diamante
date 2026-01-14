@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        
    
        
        <!-- Encabezado -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Editar Proveedor</h1>
            @if(isset($provider) && $provider)
                <div class="flex items-center space-x-4 text-sm text-gray-600">
                    <span><i class="fas fa-id-card mr-1"></i> ID: {{ $provider->id }}</span>
                    <span><i class="fas fa-calendar mr-1"></i> Creado: {{ $provider->created_at->format('d/m/Y') }}</span>
                </div>
            @endif
        </div>

        @if(isset($provider) && $provider)
        <!-- Formulario CORREGIDO -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('providers.update', $provider->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Información básica -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Información Básica</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nombre del Proveedor *
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name"
                                       value="{{ $provider->name }}" 
                                       required
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- RFC -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    RFC
                                </label>
                                <input type="text" 
                                       name="rfc" 
                                       id="rfc"
                                       value="{{ $provider->rfc }}"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4">
                                @error('rfc')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Información de contacto -->
                    <div class="pt-6 border-t border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Información de Contacto</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Persona de contacto -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Persona de Contacto
                                </label>
                                <input type="text" 
                                       name="contact_person" 
                                       id="contact_person"
                                       value="{{ $provider->contact_person }}"
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
                                <input type="text" 
                                       name="phone" 
                                       id="phone"
                                       value="{{ $provider->phone }}"
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
                                <input type="email" 
                                       name="email" 
                                       id="email"
                                       value="{{ $provider->email }}"
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
                                <textarea name="address" 
                                          id="address"
                                          rows="3"
                                          class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4">{{ $provider->address }}</textarea>
                                @error('address')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Estado y notas -->
                    <div class="pt-6 border-t border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Configuración</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Estado -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Estado *
                                </label>
                                <select name="status" 
                                        id="status"
                                        required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4">
                                    <option value="active" {{ $provider->status == 'active' ? 'selected' : '' }}>
                                        Activo
                                    </option>
                                    <option value="inactive" {{ $provider->status == 'inactive' ? 'selected' : '' }}>
                                        Inactivo
                                    </option>
                                    <option value="pending" {{ $provider->status == 'pending' ? 'selected' : '' }}>
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
                                <textarea name="notes" 
                                          id="notes"
                                          rows="4"
                                          class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4">{{ $provider->notes }}</textarea>
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
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Mostrar datos actuales -->
        <div class="mt-8 bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Datos Actuales del Proveedor</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-lg border">
                    <p class="text-sm text-gray-600">Nombre</p>
                    <p class="font-medium">{{ $provider->name }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg border">
                    <p class="text-sm text-gray-600">Estado</p>
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium 
                        {{ $provider->status == 'active' ? 'bg-green-100 text-green-800' : 
                           ($provider->status == 'inactive' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                        {{ $provider->status }}
                    </span>
                </div>
                <div class="bg-white p-4 rounded-lg border">
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-medium">{{ $provider->email ?: 'No registrado' }}</p>
                </div>
            </div>
        </div>
        
        @else
        <!-- Mensaje si no hay proveedor -->
        <div class="bg-red-50 border border-red-200 rounded-xl p-8 text-center">
            <i class="fas fa-exclamation-circle text-red-400 text-5xl mb-4"></i>
            <h3 class="text-xl font-semibold text-red-800 mb-2">Error al cargar el proveedor</h3>
            <p class="text-red-700 mb-6">No se pudo cargar la información del proveedor.</p>
            <a href="{{ route('providers.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-arrow-left mr-2"></i> Volver a la lista
            </a>
        </div>
        @endif
    </div>
</div>

@endsection