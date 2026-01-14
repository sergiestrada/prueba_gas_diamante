@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Cálculo de Utilidades</h1>
    
    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                <input type="date" name="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                <input type="date" name="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Proveedor</label>
                <select name="provider_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos</option>
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Filtrar
                </button>
            </div>
        </form>
    </div>
    
    <!-- Resumen General -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Total Ingresos</h3>
            <p class="text-3xl font-bold text-green-600">${{ number_format($totalIncome, 2) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Total Gastos</h3>
            <p class="text-3xl font-bold text-red-600">${{ number_format($totalExpense, 2) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Utilidad Bruta</h3>
            <p class="text-3xl font-bold {{ $totalUtility >= 0 ? 'text-green-600' : 'text-red-600' }}">
                ${{ number_format($totalUtility, 2) }}
            </p>
        </div>
    </div>
    
    <!-- Tabla por Proveedor -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proveedor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ingresos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gastos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($providers as $provider)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $provider->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-green-600 font-semibold">${{ number_format($provider->total_income, 2) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-red-600 font-semibold">${{ number_format($provider->total_expense, 2) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold {{ $provider->utility >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    ${{ number_format($provider->utility, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button onclick="toggleDetails({{ $provider->id }})" 
                                        class="text-blue-600 hover:text-blue-900 font-medium">
                                    Ver Detalles
                                </button>
                            </td>
                        </tr>
                        <!-- Detalles ocultos -->
                        <tr id="details-{{ $provider->id }}" class="hidden bg-gray-50">
                            <td colspan="5" class="px-6 py-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Ingresos -->
                                    <div>
                                        <h4 class="font-semibold text-gray-700 mb-2">Ingresos</h4>
                                        @foreach($provider->incomes as $income)
                                            <div class="mb-2 p-2 bg-white rounded border">
                                                <p class="text-sm"><strong>Concepto:</strong> {{ $income->concept }}</p>
                                                <p class="text-sm"><strong>Monto:</strong> ${{ number_format($income->amount, 2) }}</p>
                                                <p class="text-sm"><strong>Fecha:</strong> {{ $income->date->format('d/m/Y') }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Gastos -->
                                    <div>
                                        <h4 class="font-semibold text-gray-700 mb-2">Gastos</h4>
                                        @foreach($provider->expenses as $expense)
                                            <div class="mb-2 p-2 bg-white rounded border">
                                                <p class="text-sm"><strong>Concepto:</strong> {{ $expense->concept }}</p>
                                                <p class="text-sm"><strong>Monto:</strong> ${{ number_format($expense->amount, 2) }}</p>
                                                <p class="text-sm"><strong>Fecha:</strong> {{ $expense->date->format('d/m/Y') }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function toggleDetails(providerId) {
    const detailsRow = document.getElementById(`details-${providerId}`);
    detailsRow.classList.toggle('hidden');
}
</script>
@endsection