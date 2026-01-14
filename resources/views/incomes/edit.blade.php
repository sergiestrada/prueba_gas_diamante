@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
  
        <div class="mb-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Editar Ingreso</h1>
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            <span>Fecha: {{ $income->formatted_date }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-dollar-sign mr-1"></i>
                            <span>Monto: {{ $income->formatted_amount }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-user-tie mr-1"></i>
                            <span>Proveedor: {{ $income->provider->name }}</span>
                        </div>
                    </div>
                </div>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-400 mr-2"></i>
                        <span class="text-sm font-medium text-yellow-800">Editando registro existente</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="{{ route('incomes.update', $income) }}" method="POST">
                @csrf
                @method('PUT')
                @include('incomes._form')
            </form>
        </div>

        <!-- Información del registro -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Información del Registro</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Creado:</span>
                        <span class="font-medium">{{ $income->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Última modificación:</span>
                        <span class="font-medium">{{ $income->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID del registro:</span>
                        <span class="font-mono text-gray-800">#{{ str_pad($income->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-red-700 mb-2">Zona de peligro</h3>
                <p class="text-sm text-red-600 mb-3">Eliminar este ingreso es una acción permanente.</p>
                <form action="{{ route('incomes.destroy', $income) }}" method="POST" 
                      onsubmit="return confirm('¿Está seguro de eliminar este ingreso? Esta acción no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 flex items-center justify-center">
                        <i class="fas fa-trash mr-2"></i> Eliminar Ingreso
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection