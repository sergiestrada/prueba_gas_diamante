@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gestión de Gastos</h1>
            <p class="text-gray-600 mt-1">Administre todos los gastos registrados en el sistema</p>
        </div>
        <a href="{{ route('expenses.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 flex items-center shadow">
            <i class="fas fa-plus mr-2"></i> Nuevo Gasto
        </a>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-calendar-alt mr-1"></i> Fecha Inicio
                </label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-calendar-alt mr-1"></i> Fecha Fin
                </label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-user-tie mr-1"></i> Proveedor
                </label>
                <select name="provider_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos los proveedores</option>
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}" {{ request('provider_id') == $provider->id ? 'selected' : '' }}>
                            {{ $provider->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-search mr-1"></i> Buscar
                </label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Concepto o descripción" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center">
                    <i class="fas fa-filter mr-2"></i> Filtrar
                </button>
                <a href="{{ route('expenses.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 flex items-center">
                    <i class="fas fa-redo mr-2"></i> Limpiar
                </a>
            </div>
        </form>

        <!-- Filtros rápidos -->
        <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="flex flex-wrap gap-2">
                <span class="text-sm text-gray-600 mr-2">Filtros rápidos:</span>
                <a href="{{ route('expenses.index', ['start_date' => now()->startOfMonth()->format('Y-m-d'), 'end_date' => now()->format('Y-m-d')]) }}"
                   class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full hover:bg-blue-200">
                    Este mes
                </a>
                <a href="{{ route('expenses.index', ['start_date' => now()->subMonth()->startOfMonth()->format('Y-m-d'), 'end_date' => now()->subMonth()->endOfMonth()->format('Y-m-d')]) }}"
                   class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full hover:bg-blue-200">
                    Mes anterior
                </a>
                <a href="{{ route('expenses.index', ['start_date' => now()->subDays(7)->format('Y-m-d'), 'end_date' => now()->format('Y-m-d')]) }}"
                   class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full hover:bg-blue-200">
                    Últimos 7 días
                </a>
            </div>
        </div>
    </div>

    <!-- Resumen -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total de Gastos</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">${{ number_format($totalAmount, 2) }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-money-bill-wave text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Registros Encontrados</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $expenses->total() }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-list-alt text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Promedio por Gasto</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">
                        ${{ $expenses->count() > 0 ? number_format($totalAmount / $expenses->count(), 2) : '0.00' }}
                    </p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de gastos -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Lista de Gastos</h2>
                <div class="text-sm text-gray-600">
                    Mostrando {{ $expenses->firstItem() }} - {{ $expenses->lastItem() }} de {{ $expenses->total() }} registros
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt mr-2"></i> Fecha
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-user-tie mr-2"></i> Proveedor
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-tag mr-2"></i> Concepto
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-dollar-sign mr-2"></i> Monto
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle mr-2"></i> Descripción
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-cogs mr-2"></i> Acciones
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($expenses as $expense)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-calendar-day text-red-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $expense->formatted_date }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $expense->date->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-building text-blue-600 text-xs"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $expense->provider->name }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            ID: {{ $expense->provider_id }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 font-medium">{{ $expense->concept }}</div>
                                <div class="text-xs text-gray-500 truncate max-w-xs">
                                    {{ $expense->description ?: 'Sin descripción' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-800">
                                    <i class="fas fa-arrow-down mr-1"></i>
                                    {{ $expense->formatted_amount }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700 max-w-xs truncate">
                                    {{ $expense->description ?: '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('expenses.edit', $expense) }}" 
                                       class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded"
                                       title="Editar gasto">
                                        <i class="fas fa-edit"></i>
                                    </a>
                               
                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" 
                                          class="inline" 
                                          onsubmit="return confirm('¿Está seguro de eliminar este gasto?\nEsta acción no se puede deshacer.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 p-2 hover:bg-red-50 rounded"
                                                title="Eliminar gasto">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-400 mb-4">
                                    <i class="fas fa-receipt text-5xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron gastos</h3>
                                <p class="text-gray-600 mb-4">
                                    {{ request()->hasAny(['start_date', 'end_date', 'provider_id', 'search']) 
                                        ? 'Intente con otros criterios de búsqueda.' 
                                        : 'Comience registrando su primer gasto.' }}
                                </p>
                                @if(!request()->hasAny(['start_date', 'end_date', 'provider_id', 'search']))
                                    <a href="{{ route('expenses.create') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                        <i class="fas fa-plus mr-2"></i> Registrar Primer Gasto
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        @if($expenses->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Mostrando {{ $expenses->firstItem() }} - {{ $expenses->lastItem() }} de {{ $expenses->total() }} resultados
                    </div>
                    <div>
                        {{ $expenses->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Exportar -->
    <div class="mt-6 flex justify-end">
        <button onclick="exportExpenses()"
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center">
            <i class="fas fa-file-export mr-2"></i> Exportar a Excel
        </button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Modal de detalles
    function showExpenseDetails(expenseId) {
        // Aquí podrías implementar un modal con AJAX
        alert('Funcionalidad de detalles en desarrollo para el gasto ID: ' + expenseId);
    }

    // Exportar a Excel
    function exportExpenses() {
        const params = new URLSearchParams(window.location.search);
        window.open(`/expenses/export?${params.toString()}`, '_blank');
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Establecer fechas por defecto en los inputs si no están definidas
        const today = new Date().toISOString().split('T')[0];
        const startOfMonth = new Date(new Date().getFullYear(), new Date().getMonth(), 2).toISOString().split('T')[0];
        
        const startDateInput = document.querySelector('input[name="start_date"]');
        const endDateInput = document.querySelector('input[name="end_date"]');
        
        if (!startDateInput.value && !endDateInput.value) {
            startDateInput.value = startOfMonth;
            endDateInput.value = today;
        }
    });
</script>
@endsection