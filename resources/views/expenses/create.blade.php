@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Encabezado -->
        <div class="mb-8 text-center">
            <div class="inline-block p-4 bg-red-50 rounded-full mb-4">
                <i class="fas fa-money-bill-wave text-red-600 text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Registrar Nuevo Gasto</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Complete el formulario para registrar un gasto en el sistema. 
                Los gastos registrados se utilizarán para el cálculo de utilidades.
            </p>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            <div class="mb-6 pb-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-edit text-blue-600 mr-2"></i> Información del Gasto
                </h2>
                <p class="text-gray-600 text-sm mt-1">Ingrese los datos del gasto a registrar</p>
            </div>
            
            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <!-- Proveedor -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center">
                                <i class="fas fa-user-tie text-blue-500 mr-2"></i>
                                Proveedor <span class="text-red-500 ml-1">*</span>
                            </span>
                        </label>
                        <select name="provider_id" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 py-3 px-4">
                            <option value="">Seleccione un proveedor</option>
                            @foreach($providers as $provider)
                                <option value="{{ $provider->id }}" {{ old('provider_id') == $provider->id ? 'selected' : '' }}>
                                    {{ $provider->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('provider_id')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Concepto y Monto -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <i class="fas fa-tag text-blue-500 mr-2"></i>
                                    Concepto <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <input type="text" name="concept" value="{{ old('concept') }}" required
                                   placeholder="Ej: Compra de materiales, Pago de servicios"
                                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 py-3 px-4">
                            @error('concept')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <i class="fas fa-dollar-sign text-blue-500 mr-2"></i>
                                    Monto <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-lg">$</span>
                                </div>
                                <input type="number" name="amount" step="0.01" min="0.01" 
                                       value="{{ old('amount') }}" required
                                       placeholder="0.00"
                                       class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 py-3 px-4">
                            </div>
                            @error('amount')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Fecha -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center">
                                <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                                Fecha del Gasto <span class="text-red-500 ml-1">*</span>
                            </span>
                        </label>
                        <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 py-3 px-4">
                        @error('date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center">
                                <i class="fas fa-align-left text-blue-500 mr-2"></i>
                                Descripción Detallada
                            </span>
                            <span class="text-xs text-gray-500 font-normal">(Opcional)</span>
                        </label>
                        <textarea name="description" rows="4"
                                  placeholder="Describa el gasto con detalle. Ej: Compra de material de oficina para el departamento de ventas..."
                                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 py-3 px-4">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Botones -->
                <div class="mt-10 pt-6 border-t border-gray-200 flex justify-end space-x-4">
                    <a href="{{ route('expenses.index') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center shadow">
                        <i class="fas fa-save mr-2"></i> Registrar Gasto
                    </button>
                </div>
            </form>
        </div>

        <!-- Tips y recomendaciones -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-lightbulb text-blue-500 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-blue-800 mb-2">Recomendaciones</h3>
                        <ul class="space-y-2 text-blue-700">
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                <span>Utilice conceptos específicos para facilitar la clasificación</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                <span>Incluya descripciones detalladas para mejor trazabilidad</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                <span>Verifique que el proveedor esté correctamente seleccionado</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-yellow-800 mb-2">Importante</h3>
                        <ul class="space-y-2 text-yellow-700">
                            <li class="flex items-start">
                                <i class="fas fa-info-circle mr-2 mt-1"></i>
                                <span>Los gastos afectan directamente el cálculo de utilidades</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-info-circle mr-2 mt-1"></i>
                                <span>Revise cuidadosamente los montos antes de registrar</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-info-circle mr-2 mt-1"></i>
                                <span>La fecha debe corresponder a la fecha real del gasto</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Formatear automáticamente el monto
        const amountInput = document.querySelector('input[name="amount"]');
        amountInput.addEventListener('blur', function() {
            if (this.value) {
                let value = parseFloat(this.value);
                if (!isNaN(value)) {
                    this.value = value.toFixed(2);
                }
            }
        });

        // Sugerir conceptos comunes
        const conceptInput = document.querySelector('input[name="concept"]');
        const commonConcepts = [
            'Compra de materiales',
            'Servicios de mantenimiento',
            'Pago de servicios básicos',
            'Gastos de oficina',
            'Transporte y logística',
            'Combustible',
            'Pago de nómina',
            'Honorarios profesionales',
            'Publicidad y marketing',
            'Arrendamiento'
        ];

        conceptInput.addEventListener('focus', function() {
            if (!this.value) {
                this.setAttribute('list', 'concept-list');
            }
        });

        // Crear datalist para sugerencias
        const datalist = document.createElement('datalist');
        datalist.id = 'concept-list';
        commonConcepts.forEach(concept => {
            const option = document.createElement('option');
            option.value = concept;
            datalist.appendChild(option);
        });
        document.body.appendChild(datalist);
        conceptInput.setAttribute('list', 'concept-list');
    });
</script>
@endsection