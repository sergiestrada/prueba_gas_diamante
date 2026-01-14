@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Gestión de Ingresos</h1>
        <a href="{{ route('incomes.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center">
            <i class="fas fa-plus mr-2"></i> Nuevo Ingreso
        </a>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Inicio</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Fin</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Proveedor</label>
                <select name="provider_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos</option>
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}" {{ request('provider_id') == $provider->id ? 'selected' : '' }}>
                            {{ $provider->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Concepto o descripción" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    <i class="fas fa-filter mr-1"></i> Filtrar
                </button>
                <a href="{{ route('incomes.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                    <i class="fas fa-redo mr-1"></i> Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- Resumen -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-green-800">Total de Ingresos</h3>
                <p class="text-2xl font-bold text-green-600">
                    @if(isset($totalAmount))
                        ${{ number_format($totalAmount, 2) }}
                    @else
                        $0.00
                    @endif
                </p>
            </div>
            <div class="text-sm text-green-700">
                {{ $incomes->total() }} registro(s) encontrado(s)
            </div>
        </div>
    </div>

    <!-- Tabla de ingresos -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proveedor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Concepto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($incomes as $income)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(isset($income->date))
                                    {{ \Carbon\Carbon::parse($income->date)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(isset($income->provider))
                                    <div class="font-medium text-gray-900">{{ $income->provider->name }}</div>
                                @else
                                    <div class="text-gray-500">Sin proveedor</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $income->concept ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(isset($income->amount))
                                    <span class="font-bold text-green-600">
                                        ${{ number_format($income->amount, 2) }}
                                    </span>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500 truncate max-w-xs">
                                    {{ $income->description ?? 'Sin descripción' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('incomes.edit', $income->id) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('incomes.destroy', $income->id) }}" method="POST" 
                                          class="inline" onsubmit="return confirm('¿Eliminar este ingreso?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-database text-4xl mb-2 block"></i>
                                No se encontraron ingresos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        @if($incomes->hasPages())
            <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                {{ $incomes->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
    
    <!-- Debug info temporal (quitar después) -->
    <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <h4 class="text-sm font-medium text-yellow-800 mb-2">Debug Info:</h4>
        <div class="text-xs text-yellow-700">
            <p>Total registros: {{ $incomes->count() }}</p>
            <p>Total monto: ${{ number_format($totalAmount ?? 0, 2) }}</p>
            @if($incomes->count() > 0)
                <p>Primer registro - Monto: 
                    @if(isset($incomes[0]->amount))
                        ${{ number_format($incomes[0]->amount, 2) }} 
                        (Raw: {{ $incomes[0]->amount }})
                    @else
                        NO TIENE MONTO
                    @endif
                </p>
                <p>Primer registro - Campos disponibles: 
                    {{ implode(', ', array_keys($incomes[0]->toArray())) }}
                </p>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verificar datos en consola
    @if($incomes->count() > 0)
        console.log('Ingresos cargados:', @json($incomes->take(3)));
        console.log('Primer ingreso monto:', '{{ $incomes[0]->amount ?? "null" }}');
    @endif
});
</script>
@endsection