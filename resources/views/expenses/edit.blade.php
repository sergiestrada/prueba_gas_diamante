@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <div class="flex items-center mb-2">
                        <div class="p-2 bg-red-100 rounded-lg mr-3">
                            <i class="fas fa-money-bill-wave text-red-600"></i>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Editar Gasto</h1>
                    </div>
                    
                    <div class="flex flex-wrap gap-4 text-sm text-gray-600 ml-11">
                        <div class="flex items-center">
                            <i class="fas fa-hashtag text-gray-400 mr-1"></i>
                            <span class="font-mono">ID: #{{ str_pad($expense->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar text-gray-400 mr-1"></i>
                            <span>Fecha: {{ $expense->formatted_date }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-dollar-sign text-gray-400 mr-1"></i>
                            <span>Monto: {{ $expense->formatted_amount }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-400 mr-2"></i>
                        <div>
                            <p class="text-sm font-medium text-yellow-800">Editando registro existente</p>
                            <p class="text-xs text-yellow-600">Los cambios se reflejarán en los cálculos de utilidad</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            <form action="{{ route('expenses.update', $expense) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-edit text-blue-600 mr-2"></i> Modificar Información del Gasto
                    </h2>
                    <p class="text-gray-600 text-sm mt-1">Actualice los datos del gasto según sea necesario</p>
                </div>
                
                <div class="space-y-6">
                    <!-- Proveedor -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Proveedor <span class="text-red-500">*</span>
                        </label>
                        <select name="provider_id" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 py-3 px-4">
                            <option value="">Seleccione un proveedor</option>
                            @foreach($providers as $provider)
                                <option value="{{ $provider->id }}" 
                                        {{ old('provider_id', $expense->provider_id) == $provider->id ? 'selected' : '' }}>
                                    {{ $provider->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('provider_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Concepto y Monto -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Concepto <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="concept" value="{{ old('concept', $expense->concept) }}" required
                                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 py-3 px-4">
                            @error('concept')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Monto <span class="text-red-500">*</span>
                            </label>
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-lg">$</span>
                                </div>
                                <input type="number" name="amount" step="0.01" min="0.01" 
                                       value="{{ old('amount', $expense->amount) }}" required
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
                            Fecha <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date" value="{{ old('date', $expense->date->format('Y-m-d')) }}" required
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 py-3 px-4">
                        @error('date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción
                        </label>
                        <textarea name="description" rows="4"
                                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 py-3 px-4">{{ old('description', $expense->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Botones -->
                <div class="mt-10 pt-6 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-history mr-1"></i>
                        Última modificación: {{ $expense->updated_at->format('d/m/Y H:i') }}
                    </div>
                    
                    <div class="flex space-x-4">
                        <a href="{{ route('expenses.index') }}" 
                           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 flex items-center">
                            <i class="fas fa-times mr-2"></i> Cancelar
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center shadow">
                            <i class="fas fa-save mr-2"></i> Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Información adicional y acciones peligrosas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Información del registro -->
            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i> Información del Registro
                </h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Creado el</p>
                        <p class="font-medium">{{ $expense->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Por último usuario</p>
                        <p class="font-medium">Sistema</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Número de modificaciones</p>
                        <p class="font-medium">{{ $expense->created_at == $expense->updated_at ? '0' : '1+' }}</p>
                    </div>
                </div>
            </div>

         
            <div class="bg-blue-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-chart-line text-green-600 mr-2"></i> Impacto en Utilidades
                </h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Gastos totales del proveedor</p>
                        <p class="font-medium text-red-600">{{ $expense->provider->total_expense_formatted ?? '$0.00' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Ingresos totales del proveedor</p>
                        <p class="font-medium text-green-600">{{ $expense->provider->total_income_formatted ?? '$0.00' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Utilidad del proveedor</p>
                        <p class="font-medium {{ ($expense->provider->utility ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $expense->provider->utility_formatted ?? '$0.00' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Zona de peligro -->
            <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-red-800 mb-4 flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i> Zona de Peligro
                </h3>
                <p class="text-sm text-red-700 mb-4">
                    La eliminación de este gasto es permanente y afectará los cálculos de utilidad.
                    Esta acción no se puede deshacer.
                </p>
                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" 
                      onsubmit="return confirmDelete();">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full bg-red-600 text-white px-4 py-3 rounded-lg hover:bg-red-700 flex items-center justify-center font-medium">
                        <i class="fas fa-trash mr-2"></i> Eliminar Gasto Permanentemente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDelete() {
        const amount = "{{ $expense->formatted_amount }}";
        const provider = "{{ $expense->provider->name }}";
        const date = "{{ $expense->formatted_date }}";
        
        return confirm(`¿ESTÁ SEGURO DE ELIMINAR ESTE GASTO?\n\n` +
                      `Proveedor: ${provider}\n` +
                      `Monto: ${amount}\n` +
                      `Fecha: ${date}\n\n` +
                      `Esta acción es permanente y afectará los cálculos de utilidad.`);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Formatear monto automáticamente
        const amountInput = document.querySelector('input[name="amount"]');
        amountInput.addEventListener('blur', function() {
            if (this.value) {
                let value = parseFloat(this.value);
                if (!isNaN(value)) {
                    this.value = value.toFixed(2);
                }
            }
        });
    });
</script>
@endsection