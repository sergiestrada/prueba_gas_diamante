@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Encabezado -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Registrar Nuevo Ingreso</h1>
            <p class="text-gray-600">Complete el formulario para registrar un nuevo ingreso en el sistema.</p>
            <div class="mt-2 flex items-center text-sm text-blue-600">
                <i class="fas fa-info-circle mr-2"></i>
                Los campos marcados con <span class="text-red-500">*</span> son obligatorios
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="{{ route('incomes.store') }}" method="POST">
                @include('incomes._form')
            </form>
        </div>

     
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-lightbulb text-blue-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Recomendaciones</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Verifique que el proveedor esté registrado en el sistema</li>
                            <li>Utilice conceptos claros y descriptivos</li>
                            <li>La fecha debe coincidir con la fecha real del ingreso</li>
                            <li>Incluya una descripción detallada para mejor control</li>
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
    // Establecer fecha actual por defecto
    document.addEventListener('DOMContentLoaded', function() {
        const dateField = document.getElementById('date');
        if (!dateField.value) {
            dateField.value = new Date().toISOString().split('T')[0];
        }

        // Formatear monto automáticamente
        const amountField = document.getElementById('amount');
        amountField.addEventListener('blur', function() {
            if (this.value) {
                this.value = parseFloat(this.value).toFixed(2);
            }
        });
    });
</script>
@endsection