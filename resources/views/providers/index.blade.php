@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Gestión de Proveedores</h1>
        <p class="text-gray-600">Administre la información de todos los proveedores registrados en el sistema</p>
    </div>

    <!-- Barra de acciones -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div class="flex items-center space-x-4">
            <a href="{{ route('providers.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                <i class="fas fa-plus mr-2"></i> Nuevo Proveedor
            </a>
           
        </div>
        
        <!-- Búsqueda -->
        <div class="w-full md:w-auto">
            <form method="GET" class="flex">
                <div class="relative flex-grow">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Buscar proveedor..." 
                           class="w-full md:w-64 rounded-l-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-4">
                </div>
                <button type="submit" 
                        class="bg-gray-200 text-gray-700 rounded-r-lg px-4 py-2 hover:bg-gray-300 border border-l-0 border-gray-300">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Resumen -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Proveedores</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $providers->total() }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Activos</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">
                        {{ $providers->where('status', 'active')->count() }}
                    </p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Inactivos</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">
                        {{ $providers->where('status', 'inactive')->count() }}
                    </p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pendientes</p>
                    <p class="text-2xl font-bold text-yellow-600 mt-1">
                        {{ $providers->where('status', 'pending')->count() }}
                    </p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de proveedores -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Lista de Proveedores</h2>
                <div class="text-sm text-gray-600">
                    Mostrando {{ $providers->firstItem() }} - {{ $providers->lastItem() }} de {{ $providers->total() }}
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-building mr-2"></i> Proveedor
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-chart-line mr-2"></i> Estadísticas
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-phone mr-2"></i> Contacto
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-tag mr-2"></i> Estado
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
                    @forelse($providers as $provider)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <!-- Nombre y RFC -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-user-tie text-blue-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $provider->name }}
                                        </div>
                                        @if($provider->rfc)
                                            <div class="text-xs text-gray-500 font-mono">
                                                RFC: {{ $provider->rfc }}
                                            </div>
                                        @endif
                                        <div class="text-xs text-gray-500">
                                            ID: #{{ str_pad($provider->id, 4, '0', STR_PAD_LEFT) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Estadísticas -->
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-600">Ingresos:</span>
                                        <span class="font-medium text-green-600">
                                            ${{ number_format($provider->incomes->sum('amount'), 2) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-600">Gastos:</span>
                                        <span class="font-medium text-red-600">
                                            ${{ number_format($provider->expenses->sum('amount'), 2) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-600">Utilidad:</span>
                                        @php
                                            $utility = $provider->incomes->sum('amount') - $provider->expenses->sum('amount');
                                        @endphp
                                        <span class="font-medium {{ $utility >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            ${{ number_format($utility, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Contacto -->
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    @if($provider->contact_person)
                                        <div class="text-sm text-gray-900 flex items-center">
                                            <i class="fas fa-user text-gray-400 mr-2 text-xs"></i>
                                            {{ $provider->contact_person }}
                                        </div>
                                    @endif
                                    @if($provider->email)
                                        <div class="text-sm text-gray-600 flex items-center truncate max-w-xs">
                                            <i class="fas fa-envelope text-gray-400 mr-2 text-xs"></i>
                                            {{ $provider->email }}
                                        </div>
                                    @endif
                                    @if($provider->phone)
                                        <div class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-phone text-gray-400 mr-2 text-xs"></i>
                                            {{ $provider->phone }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Estado -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($provider->status == 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Activo
                                    </span>
                                @elseif($provider->status == 'inactive')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Inactivo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i> Pendiente
                                    </span>
                                @endif
                                
                                <div class="text-xs text-gray-500 mt-1">
                                    Registrado: {{ $provider->created_at->format('d/m/Y') }}
                                </div>
                            </td>
                            
                            <!-- Acciones -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('providers.edit', $provider) }}" 
                                       class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded"
                                       title="Editar proveedor">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('utilities.index', ['provider_id' => $provider->id]) }}"
                                       class="text-green-600 hover:text-green-900 p-2 hover:bg-green-50 rounded"
                                       title="Ver utilidades">
                                        <i class="fas fa-chart-bar"></i>
                                    </a>
                                  
                                    <form action="{{ route('providers.destroy', $provider) }}" method="POST" 
                                          class="inline" 
                                          onsubmit="return confirm('¿Eliminar este proveedor y todos sus registros asociados?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 p-2 hover:bg-red-50 rounded"
                                                title="Eliminar proveedor">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-gray-400 mb-4">
                                    <i class="fas fa-users text-5xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron proveedores</h3>
                                <p class="text-gray-600 mb-4">
                                    {{ request()->has('search') 
                                        ? 'No hay resultados para su búsqueda.' 
                                        : 'Comience registrando su primer proveedor.' }}
                                </p>
                                @if(!request()->has('search'))
                                    <a href="{{ route('providers.create') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                        <i class="fas fa-plus mr-2"></i> Registrar Primer Proveedor
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        @if($providers->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Mostrando {{ $providers->firstItem() }} - {{ $providers->lastItem() }} de {{ $providers->total() }} resultados
                    </div>
                    <div>
                        {{ $providers->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Información adicional -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-400 text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium text-blue-800 mb-2">Información sobre proveedores</h3>
                <div class="text-blue-700">
                    <p class="mb-2">Los proveedores son empresas o personas que proveen bienes o servicios a su organización.</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Cada proveedor puede tener múltiples ingresos y gastos asociados</li>
                        <li>La utilidad se calcula por proveedor para facilitar el análisis</li>
                        <li>Mantenga la información de contacto actualizada para mejor comunicación</li>
                        <li>Use estados para identificar proveedores activos, inactivos o pendientes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function showProviderDetails(providerId) {
        // Implementar modal con detalles del proveedor usando AJAX
        fetch(`/api/providers/${providerId}`)
            .then(response => response.json())
            .then(data => {
                // Mostrar modal con detalles
                const modalContent = `
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-4">Detalles del Proveedor</h3>
                        <div class="space-y-4">
                            <div>
                                <strong>Nombre:</strong> ${data.name}
                            </div>
                            ${data.rfc ? `<div><strong>RFC:</strong> ${data.rfc}</div>` : ''}
                            ${data.contact_person ? `<div><strong>Contacto:</strong> ${data.contact_person}</div>` : ''}
                            ${data.email ? `<div><strong>Email:</strong> ${data.email}</div>` : ''}
                            ${data.phone ? `<div><strong>Teléfono:</strong> ${data.phone}</div>` : ''}
                            <div>
                                <strong>Estado:</strong> ${data.status}
                            </div>
                            <div>
                                <strong>Registrado:</strong> ${new Date(data.created_at).toLocaleDateString()}
                            </div>
                        </div>
                    </div>
                `;
                // Aquí puedes usar un modal library o crear uno propio
                alert('Detalles del proveedor ID: ' + providerId);
            })
            .catch(error => console.error('Error:', error));
    }

  
</script>
@endsection