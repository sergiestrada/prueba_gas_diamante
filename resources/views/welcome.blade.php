@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-gray-100 py-12">
    <div class="container mx-auto px-4">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <div class="inline-block p-6 bg-white rounded-2xl shadow-lg mb-8">
                <i class="fas fa-chart-line text-5xl text-blue-600"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Sistema de Gestión de Utilidades
                <span class="text-blue-600">Gas Diamante REPSA</span>
            </h1>
         
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-16">
            @php
                $totalIncome = \App\Models\Income::sum('amount');
                $totalExpense = \App\Models\Expense::sum('amount');
                $totalUtility = $totalIncome - $totalExpense;
                $providerCount = \App\Models\Provider::count();
            @endphp
            
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Ingresos Totales</p>
                        <p class="text-2xl font-bold text-green-600 mt-2">${{ number_format($totalIncome, 2) }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-money-bill-wave text-green-600 text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                    Ingresos registrados en el sistema
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Gastos Totales</p>
                        <p class="text-2xl font-bold text-red-600 mt-2">${{ number_format($totalExpense, 2) }}</p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-full">
                        <i class="fas fa-receipt text-red-600 text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    <i class="fas fa-arrow-down text-red-500 mr-1"></i>
                    Gastos registrados en el sistema
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Utilidad Bruta</p>
                        <p class="text-2xl font-bold {{ $totalUtility >= 0 ? 'text-green-600' : 'text-red-600' }} mt-2">
                            ${{ number_format($totalUtility, 2) }}
                        </p>
                    </div>
                    <div class="{{ $totalUtility >= 0 ? 'bg-green-100' : 'bg-red-100' }} p-3 rounded-full">
                        <i class="fas fa-chart-line {{ $totalUtility >= 0 ? 'text-green-600' : 'text-red-600' }} text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    <i class="fas fa-calculator text-blue-500 mr-1"></i>
                    Ingresos - Gastos
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Proveedores</p>
                        <p class="text-2xl font-bold text-blue-600 mt-2">{{ $providerCount }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-users text-blue-600 text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    <i class="fas fa-building text-blue-500 mr-1"></i>
                    Proveedores registrados
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-16">
            <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Acciones Rápidas</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('utilities.index') }}" 
                   class="group bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl p-6 text-center hover:shadow-2xl transition-all duration-300">
                    <div class="mb-4">
                        <i class="fas fa-chart-bar text-4xl group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Ver Utilidades</h3>
                    <p class="text-blue-100 text-sm">Calcule y visualice utilidades brutas</p>
                </a>

                <a href="{{ route('providers.create') }}" 
                   class="group bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl p-6 text-center hover:shadow-2xl transition-all duration-300">
                    <div class="mb-4">
                        <i class="fas fa-user-plus text-4xl group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Nuevo Proveedor</h3>
                    <p class="text-green-100 text-sm">Registre un nuevo proveedor</p>
                </a>

                <a href="{{ route('incomes.create') }}" 
                   class="group bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl p-6 text-center hover:shadow-2xl transition-all duration-300">
                    <div class="mb-4">
                        <i class="fas fa-money-bill text-4xl group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Registrar Ingreso</h3>
                    <p class="text-emerald-100 text-sm">Ingrese un nuevo ingreso</p>
                </a>

                <a href="{{ route('expenses.create') }}" 
                   class="group bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl p-6 text-center hover:shadow-2xl transition-all duration-300">
                    <div class="mb-4">
                        <i class="fas fa-receipt text-4xl group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Registrar Gasto</h3>
                    <p class="text-red-100 text-sm">Ingrese un nuevo gasto</p>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Actividad Reciente</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proveedor</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $recentIncomes = \App\Models\Income::with('provider')
                                ->latest()
                                ->take(5)
                                ->get();
                            $recentExpenses = \App\Models\Expense::with('provider')
                                ->latest()
                                ->take(5)
                                ->get();
                            $recentActivities = $recentIncomes->concat($recentExpenses)
                                ->sortByDesc('created_at')
                                ->take(10);
                        @endphp
                        
                        @forelse($recentActivities as $activity)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($activity instanceof \App\Models\Income)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-arrow-up mr-1"></i> Ingreso
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-arrow-down mr-1"></i> Gasto
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $activity->concept }}</div>
                                    <div class="text-sm text-gray-500 truncate max-w-xs">{{ $activity->description }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($activity instanceof \App\Models\Income)
                                        <span class="font-bold text-green-600">${{ number_format($activity->amount, 2) }}</span>
                                    @else
                                        <span class="font-bold text-red-600">${{ number_format($activity->amount, 2) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $activity->date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $activity->provider->name }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-2"></i>
                                    <p>No hay actividad reciente</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6 text-center">
                <a href="{{ route('utilities.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    Ver todas las actividades <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection