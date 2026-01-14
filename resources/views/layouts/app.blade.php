<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gas Diamante REPSA - Gestión de Utilidades</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navegación -->
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="text-xl font-bold text-gray-800">
                  <a href="/">  Gas Diamante REPSA</a>
                </div>
                <div class="space-x-4">
                    <a href="{{ route('utilities.index') }}" class="text-gray-600 hover:text-gray-900 {{ request()->routeIs('utilities.*') ? 'font-bold text-blue-600' : '' }}">
                        Utilidades
                    </a>
                    <a href="{{ route('providers.index') }}" class="text-gray-600 hover:text-gray-900 {{ request()->routeIs('providers.*') ? 'font-bold text-blue-600' : '' }}">
                        Proveedores
                    </a>
                    <a href="{{ route('incomes.index') }}" class="text-gray-600 hover:text-gray-900 {{ request()->routeIs('incomes.*') ? 'font-bold text-blue-600' : '' }}">
                        Ingresos
                    </a>
                    <a href="{{ route('expenses.index') }}" class="text-gray-600 hover:text-gray-900 {{ request()->routeIs('expenses.*') ? 'font-bold text-blue-600' : '' }}">
                        Gastos
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        @yield('content')
    </main>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>